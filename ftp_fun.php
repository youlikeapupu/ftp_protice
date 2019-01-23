<?php
	function example()
    {
    	$filename = '/test/upload_test.php';
    	$target = '/uploadTest';
    	//上傳檔案
    	$this->seven_upload($filename, $target);

    	//下載檔案
    	$down_ein_file = 'download_test.php';
        $data = $this->get_xml($down_ein_file,$target);

        //取得遠端資料夾內的檔案列表
        $ftp_list = $this->seven_list('/PPS');
    }


	function ftp_info()
    {
        $f = new \stdclass();
        $f->host = 'test.com.tw';
        $f->user = 'xxx';
        $f->pass = 'xxxxxx';

        return $f;
    }

    function seven_upload($filename, $target)
    {

        $f = $this->ftp_info();

        $target_dir = $target;
        $local_dir = base_path('resources')."\\";
        $file = $filename;
        ftp_upload($f, $file, $local_dir, $target_dir);
    }

    function seven_download($filename, $target)
    {

        $f = $this->ftp_info();

        $target_dir = $target;
        $local_dir = base_path('resources')."\\";
        $file = $filename;
        ftp_download($f, $file, $local_dir, $target_dir);

    }

    function seven_list($target)
    {
        $f = $this->ftp_info();

        return ftp_read($f, $target);

    }

	/**
	// ftp 下載檔案
	$ftp：連線物件 (object)
	$file：本機檔案 (string)
	$local_dir：本機路徑
	$target_dir：目標路徑 (string)
	**/
	function ftp_download($ftp, $file, $local_dir, $target_dir){

	    $r_text = false;

	    // 遠端檔案
	    $remote_file = $target_dir.'/'.$file;

	    // 本機儲存檔案名稱
	    $local_file = $local_dir.$file;

	    // FTP 連接
	    $conn_id = ftp_connect($ftp->host) or die("Couldn't connect to $ftp_server");

	    // FTP 登入
	    $login_result = ftp_login($conn_id, $ftp->user, $ftp->pass) or die("Couldn't connect to $login_result");

	    if($login_result){
	        ftp_pasv($conn_id, true);

	        // 本機寫入檔案
	        $handle = fopen($local_file, 'w');
	        // 下載成功
	        if (ftp_fget($conn_id, $handle, $remote_file, FTP_BINARY)) {
	            // echo "下載成功, 並儲存到 $local_file\n";
	            $r_text = true;
	        }
	        ftp_close($conn_id);
	        fclose($handle);
	    }
	    return $r_text;
	}

	/**
	// ftp 上傳檔案
	$ftp：連線物件 (object)
	$file：本機檔案 (string)
	$local_dir：本機路徑
	$target_dir：目標路徑 (string)
	**/
	function ftp_upload($ftp, $file, $local_dir, $target_dir){

	    $r_text = false;

	    // FTP 連接
	    $conn_id = ftp_connect($ftp->host) or die("Couldn't connect to $ftp_server");

	    // FTP 登入
	    $login_result = ftp_login($conn_id, $ftp->user, $ftp->pass) or die("Couldn't connect to $login_result");

	    if($login_result){
	        ftp_pasv($conn_id, true);

	        // 遠端檔案
	        $remote_file = $target_dir.'/'.$file;

	        // 本機儲存檔案名稱
	        $local_file = $local_dir.$file;

	        // 本機讀取檔案
	        $fp = fopen($local_file, 'r');

	        // 上傳檔案
	        if (ftp_fput($conn_id, $remote_file, $fp, FTP_BINARY)) {
	            // echo "成功上傳 $file\n";
	            $r_text = true;
	        }
	        ftp_close($conn_id);
	        fclose($fp);
	    }
	    return $r_text;
	}

	function ftp_read($ftp, $target_dir){
	    // FTP 連接
	    $conn_id = ftp_connect($ftp->host) or die("Couldn't connect to $ftp_server");

	    // FTP 登入
	    $login_result = ftp_login($conn_id, $ftp->user, $ftp->pass) or die("Couldn't connect to $login_result");

	    if($login_result){
	        $ftp_arr = ftp_nlist($conn_id,$target_dir);
	    }
	    ftp_close($conn_id);

	    return $ftp_arr;
	}

?>
