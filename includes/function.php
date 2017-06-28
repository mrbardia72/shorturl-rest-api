<?php
/**
 * Created by: sajjad kazemi
 * Email: sajad.kazemi1993@gmail.com
 * telegram: @sajjadkazemi10
 * Date: 2017-06-10
 * location: iran,gilan,langroud
 */
/*creat class shorturl*/
class shorturl
{
    public $pdo;

    function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    }

    /* Create short code*/
    function rand_str()
    {
        $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
        $short_code = '';
        while (strlen($short_code) < 7) {
            $short_code .= $chars[rand(0, strlen($chars))];
        }
        return $short_code;
    }

    function check_rand_str()
    {
        $short_code1 = $this->rand_str();
        $stm1=$this->pdo->prepare('SELECT * FROM urls WHERE short_code = :shortcode');
        $stm1->bindParam( ':shortcode', $short_code1);
        $stm1->execute();
        $num1 = $stm1->rowCount();
        if($num1 == 0)
        {
            return $short_code1;
        }
        else
        {
            $short_code1 = $this->rand_str();
        }
    }

    /* return true if url format valid*/
    function valid_Url($path)
    {
        //return filter_var($path , FILTER_VALIDATE_URL);
        return preg_match("/\b(?:\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $path);
    }

    /*start code key to username*/
    public function key_to_username($key){
        $stm4 = $this->pdo->prepare('SELECT username FROM permission WHERE keyd=:key1');
        $stm4->bindParam(':key1', $key);
        $stm4->execute();
        $r4 = $stm4->fetch(PDO::FETCH_ASSOC);
       return $user=$r4['username'];
    }

    /*function counter shorturl using each username's */
    function counter_shorturl($key)
    {
        $key_user= $this->key_to_username($key);
        $stm5 = $this->pdo->prepare('SELECT * FROM urls WHERE username=:user5');
        $stm5->bindParam(':user5', $key_user);
        $stm5->execute();
        return $stm5->rowCount();
    }

    /*start- code insert to tb*/
    function insert_url_tb($path,$key)
    {
        if ($this->valid_Url($path) == true) {
            /*call function check_rand_str and varibale */
            $site='url.ir/';
            $short_code = $this->check_rand_str();
            /*call function key_to_username*/
           $key_user= $this->key_to_username($key);
           /*call function counter_shorturl*/
           $counter=$this->counter_shorturl($key);
           /*insert to table */
            $stm = $this->pdo->prepare('INSERT INTO urls (url,short_code,create_date,create_time,username) VALUES (:url2,:short_code2,:date2,:time2,:uname)');
            $stm->bindParam(':url2', $path);
            $stm->bindParam(':short_code2', $short_code);
            @$stm->bindParam(':date2', date('Y-m-j'));
            @$stm->bindParam(':time2', date('H:i:s'));
            $stm->bindParam(':uname',$key_user );
            $stm->execute();

            /* fetch to array outpur json*/
            $output_fetch = array(
                'msg' => 'stored in the database',
                'url_short' => $site . $short_code,
                'date' => date('Y-m-j'),
                'time' => date('H:i:s'),
                'your username' => $key_user,
                'counter create shorturl' => $counter+1
            );
            header('Content-Type: application/json');
            echo json_encode($output_fetch, JSON_PRETTY_PRINT);
        } else {
            $error = array('msg' => 'invalid url');
            header('Content-Type: application/json');
            echo json_encode($error, JSON_PRETTY_PRINT);
        }
    }

    /*start-fetch url in tb*/
    function fetch_url_tb($path,$key)
    {
        $site='url.ir/';
        /*call function key_to_username*/
        $key_user= $this->key_to_username($key);
        /*call function counter_shorturl*/
        $counter=$this->counter_shorturl($key);
        $stm = $this->pdo->prepare('SELECT * FROM urls WHERE url=:url2');
        $stm->bindParam(':url2', $path);
        $stm->execute();
        if ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $output_fetch = array(
                'msg' => 'Information not stored in the database. Because the database is available',
                'url_short' => $site . $row['short_code'],
                'date' => $row['create_date'],
                'time' => $row['create_time'],
                'user by' => $row['username'],
                'counter create shorturl user by' => $counter
            );
            header('Content-Type: application/json');
            echo json_encode($output_fetch, JSON_PRETTY_PRINT);
        }
    }

    /* Check url exist in table and insert to tb url*/
    function check_url_tb($path,$key)
    {
        $stm = $this->pdo->prepare('SELECT * FROM urls WHERE url=:url2');
        $stm->bindParam(':url2', $path);
        $stm->execute();
        $num = $stm->rowCount();
        if ($num == 0) {
            $this->insert_url_tb($path,$key);
        } else {
            $this->fetch_url_tb($path,$key);
        }
    }

    /*function auth_error when url in datebase haved*/
    function auth_error()
    {
        $Authentication = array('msg' => 'You do not have permission to access short link');
        header('Content-Type: application/json');
        return json_encode($Authentication, JSON_PRETTY_PRINT);
    }

    /* Authentication */
    function auth_user($kay , $path)
    {
        $stm1=$this->pdo->prepare('SELECT * FROM permission WHERE keyd = :key1');
        $stm1->bindParam( ':key1', $kay);
        $stm1->execute();
        $num1 = $stm1->rowCount();
        if($num1 == 1)
        {
            $this->check_url_tb($path,$kay);
        }
        else{
            echo $this->auth_error();
        }
    }
}
?>