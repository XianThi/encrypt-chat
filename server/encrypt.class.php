<?php
namespace XianThi\Crypter;
use Exception;
class Config{
public $db_host;
public $db_username;
public $db_password;
public $db_name;

public static function connect($db_host,$db_username,$db_password,$db_name){
$link=mysqli_connect($db_host, $db_username, $db_password, $db_name);
return $link;
}
}

class UnsafeCrypto
{
    const METHOD = 'aes-256-cfb';
    
    /**
     * Encrypts (but does not authenticate) a message
     * 
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded 
     * @return string (raw binary)
     */
    public static function encrypt($message, $key, $encode = false)
    {
        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = openssl_random_pseudo_bytes($nonceSize);
        
        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );
        
        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            return base64_encode($nonce.$ciphertext);
        }
        return $nonce.$ciphertext;
    }
    
    /**
     * Decrypts (but does not verify) a message
     * 
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */
    public static function decrypt($message, $key, $encoded = false)
    {
        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                $except=new MyException();
                $except=$except->ShowMe('Encryption failure');
              //  throw new MyException('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');
        
        $plaintext = openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );
        
        return $plaintext;
    }
}
class SaferCrypto extends UnsafeCrypto
{
    const HASH_ALGO = 'sha256';
    
    /**
     * Encrypts then MACs a message
     * 
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded string
     * @return string (raw binary)
     */
    public static function encrypt($message, $key, $encode = false)
    {
        list($encKey, $authKey) = self::splitKeys($key);
        
        // Pass to UnsafeCrypto::encrypt
        $ciphertext = parent::encrypt($message, $encKey);
        
        // Calculate a MAC of the IV and ciphertext
        $mac = hash_hmac(self::HASH_ALGO, $ciphertext, $authKey, true);
        
        if ($encode) {
            return base64_encode($mac.$ciphertext);
        }
        // Prepend MAC to the ciphertext and return to caller
        return $mac.$ciphertext;
    }
    
    /**
     * Decrypts a message (after verifying integrity)
     * 
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string (raw binary)
     */
    public static function decrypt($message, $key, $encoded = false)
    {
        list($encKey, $authKey) = self::splitKeys($key);
        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                  $except=new MyException();
                $except=$except->ShowMe('Encryption failure');
            }
        }
        
        // Hash Size -- in case HASH_ALGO is changed
        $hs = mb_strlen(hash(self::HASH_ALGO, '', true), '8bit');
        $mac = mb_substr($message, 0, $hs, '8bit');
        
        $ciphertext = mb_substr($message, $hs, null, '8bit');
        
        $calculated = hash_hmac(
            self::HASH_ALGO,
            $ciphertext,
            $authKey,
            true
        );
        
        if (!self::hashEquals($mac, $calculated)) {
                 $except=new MyException();
                $except=$except->ShowMe('Encryption failure');
            }
            
        
        
        // Pass to UnsafeCrypto::decrypt
        $plaintext = parent::decrypt($ciphertext, $encKey);
        
        return $plaintext;
    }
    


       public static function searchforkey($getkey) {
$array=self::keylist();
$return='';
foreach($array as $key => $val){
foreach($val as $keyx=>$valx){
if ($valx==$getkey){
for ( $say=1 ; $say < $keyx+1; $say++ ){
$return.=$key; }
return $return;}
}}
}


     public static function keylist(){
$keys = array (
0 => array(1=>'32',2=>'48'),
1 => array(1=>'46',2=>'44',3=>'63',4=>'33',6=>'58',7=>'59',8=>'47',9=>'49'),
2 => array(1=>'97',2=>'98',3=>'99',4=>'231',5=>'50',6=>'65',7=>'66',8=>'67',9=>'199'),
3 => array(1=>'100',2=>'101',3=>'102',4=>'51',5=>'68',6=>'69',7=>'70'),
4 => array(1=>'103',2=>'287',3=>'104',4=>'105',5=>'305',6=>'52',7=>'71',8=>'286',9=>'72',10=>'73',11=>'304'),
5 => array(1=>'106',2=>'107',3=>'108',4=>'53',5=>'74',6=>'75',7=>'76'),
6 => array(1=>'109',2=>'110',3=>'111',4=>'246',5=>'54',6=>'77',7=>'78',8=>'79',9=>'214'),
7 => array(1=>'112',2=>'113',3=>'114',4=>'115',5=>'351',6=>'55',7=>'80',8=>'81',9=>'82',10=>'83',11=>'350'),
8 => array(1=>'116',2=>'117',3=>'252',4=>'118',5=>'56',6=>'84',7=>'85',8=>'220',9=>'86'),
9 => array(1=>'119',2=>'120',3=>'121',4=>'122',5=>'57',6=>'87',7=>'88',8=>'89',9=>'90'));
return $keys;
}

public static function connectDB(){
$conn=new Config();
$conn->db_host="localhost";
$conn->db_name="encrypt";
$conn->db_username="root";
$conn->db_password="bakirkoyds";

$link= $conn->connect($conn->db_host,$conn->db_username,$conn->db_password,$conn->db_name);

return $link;

}

public static function getAction($hexpass){
$return='';
if(isset($_POST) && !empty($_POST)){
foreach($_POST as $key => $value){
if($key=="s"){
$return=self::searchforkey($_POST["s"]);
}
if($key=="e"){
$sender=$_POST["sender"];
$receiver=$_POST["receiver"];
$encryptedmessage=self::encrypt($_POST["e"],$hexpass,true);
$query="insert into messages(conv_id,from_id,message) values (".$_POST['convid'].",".$_POST['sender'].",'$encryptedmessage')";
$link=self::connectDB();
if(!$link->query($query)){
$return=mysqli_error($link);
}
}
if($key=="d"){
$message_numbers=self::decrypt($_POST["d"],$hexpass,true);  
$message_number=explode("\n",$message_numbers);
$return="<p><h1>Decrypted Message : ";
for($i=0; $i<count($message_number);$i++){
$message_number[$i] = trim(preg_replace('/\s\s+/', '\n', $message_number[$i]));
$message_key=substr($message_number[$i],0,1);
$key_count=strlen($message_number[$i]);
if($key_count==0){
    $key_count=1;}
$keys=self::keylist();
$message_decrypt=$keys[$message_key][$key_count];
$return.= html_entity_decode("&#$message_decrypt",ENT_COMPAT, 'UTF-8'); 
}
$return.= "</h1></p>";  
}
return $return;
}}else{
return $return;
}
}

function rand_secure($max){
    do{
        $result = floor($max*(hexdec(bin2hex(openssl_random_pseudo_bytes(32)))/0xffffffff));
    }while($result == $max);
    return $result;
}
    
    /**
     * Splits a key into two separate keys; one for encryption
     * and the other for authenticaiton
     * 
     * @param string $masterKey (raw binary)
     * @return array (two raw binary strings)
     */
    protected static function splitKeys($masterKey)
    {
        // You really want to implement HKDF here instead!
        return [
            hash_hmac(self::HASH_ALGO, 'ENCRYPTION', $masterKey, true),
            hash_hmac(self::HASH_ALGO, 'AUTHENTICATION', $masterKey, true)
        ];
    }
    
    /**
     * Compare two strings without leaking timing information
     * 
     * @param string $a
     * @param string $b
     * @return boolean
     */
    protected static function hashEquals($a, $b)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($a, $b);
        }
        $nonce = openssl_random_pseudo_bytes(32);
        return hash_hmac(self::HASH_ALGO, $a, $nonce) === hash_hmac(self::HASH_ALGO, $b, $nonce);
    }
}

class MyException {

  function ShowMe($except) {
   try {
    throw new Exception('<p class="bg-danger">'.$except."</p>");
   } catch (\Exception $e) {
    echo ($e->getMessage());
   }
  }

}

?>