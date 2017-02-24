<?php 
defined('C5_EXECUTE') or die("Access Denied.");

$submittedData='';
foreach($questionAnswerPairs as $questionAnswerPair){
	$submittedData .= $questionAnswerPair['question']."\r\n".$questionAnswerPair['answerDisplay']."\r\n"."\r\n";
} 
$formDisplayUrl=URL::to('/dashboard/reports/forms') . '?qsid='.$questionSetId;

$body = t("
%s form submission through the Intranet.

%s

To view previous submissions, visit %s 

", $formName, $submittedData, $formDisplayUrl);