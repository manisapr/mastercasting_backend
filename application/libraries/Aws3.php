<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of AmazonS3
 *
 * @author wahyu widodo
 */
 
 include("./vendor/autoload.php");
 
 use Aws\S3\S3Client;
 
 class Aws3{
	
	private $S3;
	public function __construct(){
		$this->S3 = S3Client::factory([
			'key' => 'AKIAIJWAE23ZFSZ6BH7A',
			'secret' => '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',
			's3_host_name' => 'castingandcad.s3-us-west-2.amazonaws.com'
		]);
	}	
	
	public function addBucket($bucketName){
		$result = $this->S3->createBucket(array(
			'Bucket'=>$bucketName,
			'LocationConstraint'=> 'us-west-2'));
		return $result;	
	}
	
	public function sendFile($bucketName, $filename, $tmp_name){
		$result = $this->S3->putObject(array(
				'Bucket' => $bucketName,
				'Key' => $filename,
				'SourceFile' => $tmp_name,
				// 'ContentType' => 'image/png',
				'StorageClass' => 'STANDARD',
				'ACL' => 'public-read'
		));
		return $result['ObjectURL']."\n";
	}
		
	 
 }