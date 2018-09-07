<?php
require FCPATH.'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3 {
	
	public function s3Upload($filepath, $saveFilename, $mime) {
		$s3 = new S3Client([
			'version' => 'latest',
			'region'  => 'ap-northeast-2',
			'credentials' => [
				'key'    => S3_KEY,
				'secret' => S3_SECRET_KEY
			]
		]);
		
		try {
			$result = $s3->putObject([
				'Bucket' => BUCKET,
				'Key' => $saveFilename,
				'ContentType'  => $mime,
				'SourceFile' => $filepath,
				'ACL' => 'public-read',
			]);
			
			return $result->get('ObjectURL');
		} catch (Aws\S3\Exception\S3Exception $e) {
			echo $e->getMessage();
			
			return null;
		}
	}
}