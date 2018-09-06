<?php
require FCPATH.'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

DEFINE('S3_KEY', 'AKIAJV5OE5NUKBM7GG4A');
DEFINE('S3_SECRET_KEY', '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');
DEFINE('BUCKET', 'thdwodn');

class S3 {
	
	public function s3Upload($filepath, $saveFilename) {
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