<?php
namespace Admin\Service;

date_default_timezone_set('Asia/Shanghai');

/**
 TLV包解析类
 */
class Tlv
{

    private $buffer;

    private $t_len = 4;
    // T长度
    private $l_len = 4;
    // L长度
    private $buf_len = 0;
    // 字节流长度
    private $buf_array = array();

    /**
     * 构造函数
     */
    function __construct()
    {}

    /**
     * 解析数据
     *
     * @param byte $buffer
     *            二进制流数据
     * @param
     *            $IsArray
     * @return array
     */
    function Read($buffer, $IsArray = false)
    {
        $this->buffer = $buffer;
        $this->buf_len = strlen($this->buffer);

        $isMore = false;
        $tmp_array = array();
        $tmp_key = "";

        // 清空数组
        if (isset($this->buf_array)) {
            unset($this->buf_array);
            $this->buf_array = array();
        }

        $i = 0;
        while ($i < $this->buf_len) {
            // 获取TGA
            $t = $this->getLength($i, $this->t_len);
            if ($this->toHex($t) == "0xffffffff")
                break;

                $i += $this->t_len;

                // 获取Length
                $l = $this->getLength($i, $this->l_len);
                $i += $this->l_len;

                // 获取Value
                $v = substr($this->buffer, $i, $l);
                $i += $l;

                if ($IsArray) {
                    $this->buf_array[$this->toHex($t)] = array(
                        $this->toHex($t),
                        $l,
                        $v
                    );
                } else {
                    array_push($this->buf_array, array(
                        $this->toHex($t),
                        $l,
                        $v
                    ));
                }
        }

        return $this->buf_array;
    }

    // 将数组转换二进制数据
    function Write($arrdata)
    {
        $i = 0;
        $msg = null;
        while ($i < count($arrdata)) {
            $msg .= $this->Pack("N*", $arrdata[$i][0]);
            $msg .= $this->Pack("N*", $arrdata[$i][1]);
            $msg .= $arrdata[$i][2];

            $i += 1;
        }

        return $msg;
    }

    // 获取值
    function getValue($key)
    {
        return $this->buf_array[$key][2];
    }

    // 转换成十六进制
    function toHex($value)
    {
        return "0x" . dechex($value);
    }

    // 压包
    function Pack($format, $data)
    {
        return pack($format, $data);
    }

    // 解包
    function Unpack($format, $data)
    {
        $ret = unpack($format, $data);
        return $ret[1];
    }

    // 清楚所有数据
    function Clear()
    {
        if (isset($this->buffer)) {
            unset($this->buffer);
        }
        $this->buf_len = 0;
    }
}

class netdiskVAC extends Tlv
{

    /**
     * CmdID_Bind 0x10000001 连接请求
     * CMDID_BindResp 0x80000001 连接应答
     * CMDID_UnBind 0x10000002 去连接请求
     * CMDID_UnBindResp 0x80000002 去连接应答
     * CMDID_Handset 0x10000003 链接握手请求
     * CMDID_HandsetResp 0x80000003 链接握手应答
     * CMDID_CheckPrice 0x10000005 鉴权批价请求
     * CMDID_CheckPriceResp 0x80000005 鉴权批价应答
     * CMDID_CheckPriceConfirm 0x10000006 鉴权批价确认请求
     * CMDID_CheckPriceConfirmResp 0x80000006 鉴权批价确认应答
     * CMDID_TrafficPrice 0x10000007 流量批价请求
     * CMDID_ TrafficPriceResp 0x80000007 流量批价应答
     * CMDID_ContentAbstractReq 0x10000008 保留、内容摘要请求
     * CMDID_ContentAbstractResp 0x80000008 保留、内容摘要响应
     */
    const CmdID_Bind = 0x10000001;
    // 连接请求
    const CMDID_BindResp = 0x80000001;
    // 连接应答
    const CMDID_UnBind = 0x10000002;
    // 去连接请求
    const CMDID_UnBindResp = 0x80000002;
    // 去连接应答
    const CMDID_Handset = 0x10000003;
    // 链接握手请求
    const CMDID_HandsetResp = 0x80000003;
    // 链接握手应答
    const CMDID_CheckPrice = 0x10000005;
    // 鉴权批 = 0求
    const CMDID_CheckPriceResp = 0x80000005;
    // 鉴权批价应答
    const CMDID_CheckPriceConfirm = 0x10000006;
    // 鉴权批价确认请求
    const CMDID_CheckPriceConfirmResp = 0x80000006;
    // 鉴权批价确认应答
    const CMDID_TrafficPrice = 0x10000007;
    // 流量批价请求
    const CMDID_TrafficPriceResp = 0x80000007;
    // 流量批价应答
    const CMDID_ContentAbstractReq = 0x10000008;
    // 保留、内容摘要请求
    const CMDID_ContentAbstractResp = 0x80000008;
    // 保留、内容摘要响应
    const READ_LENGTH = 2048;

    private $socket = false;

    public function __construct(){
        $this->setDefaultParam();
    }

    private function setDefaultParam()
    {
        /**
         * VAC 服务器地址
         */
        $this->VAC_Server = '221.7.5.176';
        /**
         * VAC 服务器端口
         */
        $this->VAC_Port = 9999;

        /**
         * 共享密钥 VAC提供
         */
        $this->PASSWORD = '123456';

        /**
         * 版本标识
         */
        $this->Version = 10;

        /**
         * 原始设备类型（SourceDevice_Type）
         * 00：VAC
         * DEVICETYPE=24 ;ISMAP客户端的设备类型
         */
        $this->SourceDevice_Type = 24;

        $this->SourceDevice_ID = '248908';

        /**
         * 省份代码
         * 新疆:089
         */
        $this->Province_Code = '089';

        /**
         * 目标设备类型
         * 00：VAC
         */
        $this->DestinationDevice_Type = 0;

        $this->DestinationDevice_ID = '008901';
        /**
         * 业务发起端地址类型
         */
        $this->OA_Type = 1;

        /**
         * 业务发起端用户归属网络标识
         */
        $this->OANetwork_ID = 'WCDMA';

        /**
         * 业务发起端地址。填写手机号码
         */
        $this->OA = '';
        /**
         * 目标地址类型
         */
        $this->DA_Type = 1;

        /**
         * 目标端用户归属网络标识
         */
        $this->DANetwork_ID = $this->OANetwork_ID;

        /**
         * 目标地址。填写手机号码
         */
        $this->DA = $this->OA;

        /**
         * 付费地址类型，填1。保留作为以后可以独立设定付费方时使用。
         */
        $this->FA_Type = 1;

        /**
         * 付费用户归属的网络标识。保留作为以后可以独立设定付费方时使用
         */
        $this->FANetwork_ID = $this->OANetwork_ID;
        /**
         * 付费地址。填手机号码。保留作为以后可以独立设定付费方时使用。
         */
        $this->FA = $this->OA;
        /**
         * 1：SPID+ServiceID
         * 3：SPID+SP_ProductID
         * 5: SPID+SPEC_ProductID
         */
        $this->ServiceIDType = 3;
        /**
         * 填写企业代码
         */
        $this->SP_ID = '82100';
        /**
         * ServiceIDType
         * 为1时填写ServiceID
         * 为3时填写SP_ProductID
         * 为5时填写SPEC_ProductID(业务部件能知晓用户定购或点播CRM的产品构成)
         */
        $this->ServiceID = '';
        /**
         * CRM产品ID, ServiceIDType为5时有效，其他填8个空格
         */
        $this->ProductID = '9089053000';

        /**
         * 业务上下行类型：
         * 1: MOAT
         * 2: AOMT
         * 3: MOMT 终端到终端
         * 4、P TO E，终端到邮箱
         * 9: 其它
         * vac对彩信p to e、sp彩信、在信、wap push业务需要判断具体取值，对其他业务不鉴权本字段
         */
        $this->Service_updown_Type = 1;
        /**
         * 重发次数：
         * 0：只发一次
         * 1-255：重发次数
         * 默认取值0
         */
        $this->ResentTimes = 1;

        /**
         * 业务类型，见VAC与BSS接口规范附录A 7
         * 当Operation Type=1、2、3、4时，VAC不对鉴权发起方的业务类型与产品的业务类型进行比较鉴权
         */
        $this->ServiceType = 1;

        /**
         * 计费类型，该字段不能为空。
         * 0：不计费，仅用于核减SP对称的信道费；
         * 1：免费
         * 2：按条/次计费
         * 3：按包月收取
         * 4：封顶计费
         * 5：按流量计费
         * 6：按时长计费
         * 7：包多月计费
         */
        $this->FeeType = 3;
        /**
         * 单位，分。
         */
        $this->Fee = 900;
    }

    public function bind()
    {
        $SequenceId = time();
        $Time_Stamp = date("mdHis");
        // echo 'time_stamp=>',$Time_Stamp . PHP_EOL;
        /**
         * 该域用来对原始端进行鉴权
         * 它生成的MD5 加密算法如下：
         * 原始端认证号码＝原始端设备ID+共享密钥+时间戳
         * 共享的密钥部分由VAC分配，时间戳由发端设备生成，
         * 格式是：MMDDHHMMSS，月日时分秒。
         * 共享密钥的最大长度是40 字节
         */
        $Check_Source = md5($this->SourceDevice_ID . $this->PASSWORD . $Time_Stamp);
        // echo 'PASSWORD=>',PASSWORD,PHP_EOL;
        // echo 'sourcedevice_id=>',SourceDevice_ID,PHP_EOL;
        // echo "check_source=>",$Check_Source,PHP_EOL;

        /**
         * SourceDevice_Type+$SourceDevice_ID+DestinationDevice_Type
         * +$DestinationDevice_ID+$Check_Source+$Time_Stamp+version
         */

        $TotalLength = 90;
        $CommandId = self::CmdID_Bind;
        // $pud_data = pack('NNNHa20Ha20H*a10i', $TotalLength, $CommandId, $SequenceId,
        // echo $TotalLength, $CommandId, $SequenceId,SourceDevice_Type,SourceDevice_ID, DestinationDevice_Type, DestinationDevice_ID, $Check_Source, $Time_Stamp, Version;
        $pud_data = pack('NNNNa20Na20H*a10i', $TotalLength, $CommandId, $SequenceId,
            $this->SourceDevice_Type, $this->SourceDevice_ID, $this->DestinationDevice_Type,
            $this->DestinationDevice_ID, $Check_Source, $Time_Stamp, $this->Version);
        // var_dump($pud_data);
        return $pud_data;
    }

    public function Handset()
    {
        $TotalLength = 16;
        $CommandId = CMDID_Handset;
        $SequenceId = time();
        $mheader = pack('NNN', $TotalLength, $CommandId, $SequenceId);
        return $mheader;
    }

    /**
     *
     * @param string $UMobile
     * @param integer $Operation_Type
     * @return string
     */
    public function CheckPrice($UMobile, $Operation_Type)
    {
        /**
         * Operation_Type
         * 0、鉴权计费
         * ServiceIDType=1时，如果请求中有LinkID，进行点播关系鉴权，无LinkID，进行订购关系鉴权，
         * 鉴权通过则进行计费。
         * 1、定购ServiceIDType必须为3
         * 2、退定 ServiceIDType必须为3
         * 3、退定ServiceType对应的所有业务（终端侧不能单独退订业务除外）：ServiceIDType必须为3
         * 4、点播：业务平台能判断是点播，直接填4
         * 6、定购关系鉴权(用于检查用户是否订购了此业务)
         * 7、屏蔽业务能力
         * 8、恢复业务能力
         */

        $SequenceId = time();
        $Time_Stamp = date("mdHis");

        $TotalLength = 319;
        $CommandId = self::CMDID_CheckPrice;

        $RandomSN = $this->randomkeys(4);

        if ($this->ServiceIDType == 3){
            $this->ServiceID = $this->ProductID;
        }

        $SequenceNumber = $Time_Stamp . $this->SourceDevice_ID . $RandomSN;
        $OA = $DA = $FA = $UMobile;
        $Begin_Time = date("YmdHis");
        $pud_data = pack('NNNNa20Na20a20Na10a36Na10a36Na10a36Na21a21a8Na14H*Na2a2a8', $TotalLength, $CommandId,$SequenceId,
            $this->SourceDevice_Type, $this->SourceDevice_ID, $this->DestinationDevice_Type, $this->DestinationDevice_ID,
            $SequenceNumber, $this->OA_Type, $this->OANetwork_ID, $OA, $this->DA_Type, $this->DANetwork_ID, $DA,
            $this->FA_Type, $this->FANetwork_ID, $FA,$this->ServiceIDType, $this->SP_ID,
            $this->ServiceID, $this->ProductID,$this->Service_updown_Type, $Begin_Time,
            $this->ResentTimes, $Operation_Type, $this->ServiceType, self::getFeeType(), self::getFee());
        return $pud_data;
    }

    // 将数组转换二进制数据
    function writeTlv($arrdata)
    {
        $i = 0;
        $msg = null;
        while ($i < count($arrdata)) {
            $msg .= $this->Pack("N*", $arrdata[$i][0]);
            $msg .= $this->Pack("N*", $arrdata[$i][1]);
            $msg .= $arrdata[$i][2];

            $i += 1;
        }

        return $msg;
    }

    function getContentID($Content){
        $tag = 0x1510;
        $value = Tlv::Write($Content);
        $ret = array($tag,strlen($value),$value);
        return Tlv::Write($ret);
    }

    private function getFeeType(){
        $tag = 0x1202;
        $value = Tlv::Write($this->FeeType);
        $ret = array($tag,strlen($value),$value);
        return Tlv::Write($ret);

    }

    private function getFee(){
        $tag = 0x1508;
        $value = Tlv::Write($this->Fee);
        $ret = array($tag,strlen($value),$value);
        return Tlv::Write($ret);
    }

    private function randomkeys($length)
    {
        $key = "";
        for ($i = 0; $i < $length; $i ++) {
            $key .= mt_rand(0, 9); // 生成php随机数
        }
        return $key;
    }

    public function unbind()
    {
        $SequenceId = time();

        $CommandId = self::CMDID_UnBind;

        $TotalLength = 12;

        $pud_data = pack('NNN', $TotalLength, $CommandId, $SequenceId);
        return $pud_data;
    }

    public function connectionSocket()
    {
        $conn = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (! $conn) {
            return array(
                'ret' => 1,
                'msg' => "socket_create() failed: reason: " . socket_strerror(socket_last_error())
            );
        }

        $ret = socket_connect($conn, $this->VAC_Server, $this->VAC_Port);
        if (! $ret) {
            return array(
                'ret' => 1,
                'msg' => "socket_connect() failed.\nReason: ($ret) " . socket_strerror(socket_last_error($conn))
            );
        }
        $this->socket = $conn;
        return array(
            'ret' => 0,
            'msg' => ""
        );
    }

    public function closeSocket()
    {
        if ($this->socket) {
            return true;
        } else {
            socket_close($this->socket);
        }
    }

    public function socksend($in)
    {
        $out = '';
        $conn = $this->socket ? $this->socket : $this->connectionSocket();

        socket_write($conn, $in, strlen($in));

        $out = socket_read($conn, self::READ_LENGTH);
        return self::unpackResp($out);
    }

    /**
     * 从二进制字符串对数据进行解包
     *
     * @param type $str
     * @return type
     *
     */
    private function unpackResp($input)
    // Binary representation of a binary-string
    {
        if (! is_string($input))
            return null; // Sanity check

        // Unpack as a hexadecimal string
        return unpack('N*', $input);
    }
}

// echo "*********************";
// echo PHP_EOL;

// echo "*********************";
// echo PHP_EOL;


// $vac = new netdiskVAC();
// $vac->connectionSocket();
// $bind_pud = $vac->bind();
// $res = $vac->socksend($bind_pud);
// echo PHP_EOL;
// var_dump($res);
// echo PHP_EOL;
// $UMobile = '18699111272';
// $Operation_Type = 1;
// $fee = 900;

// $check_data = $vac->CheckPrice($UMobile, $Operation_Type);
// $ret_check = $vac->socksend($check_data);
// echo PHP_EOL;
// var_dump($ret_check);
// // $unbind = $vac->unbind();
// // $unres = $vac->socksend($unbind);
// // var_dump($unres);
// // $vac->closeSocket();




