<?php 
include 'connect.php';
require 'vendor/autoload.php';
ini_set('max_execution_time', 90); //90 seconds = 1 minute 30 seconds
error_reporting(0); 

function sendMail($conn,$uniq_id,$from_email,$to_email,$message){
    
    
    
    $toSel = 'matrix_unique_id, MLSNumber, BathsTotal, BedsTotal, City, CurrentPrice, GarageSpaces, PropertyAddress, SubCondoName, TotalArea, PropertyType, PropertyInformation, DefaultPic';
    $sqlPpty = "SELECT $toSel FROM properties WHERE MLSNumber='$uniq_id'";
    $pptyRslt = mysqli_query($conn,$sqlPpty) or die(mysqli_error($conn));
    $pptyExist=mysqli_num_rows($pptyRslt);
    
    if($pptyExist>0){ 
    $row = mysqli_fetch_array($pptyRslt);
    extract($row); 
    $link = preg_replace("/[^a-zA-Z0-9-_]+/", "-", $PropertyAddress);
    
    $subject = $from_email." shared a home on MVP Realty"; 
    $emailBody ='<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="background-color:#ffffff" role="presentation">
    <tbody>
      <tr>
         <td bgcolor="#FFFFFF" width="100%" style="vertical-align:top" valign="top">
            <div style="font-size:13px;color:#ffffff" class="m_-5162911287275600565spacer">&nbsp;</div>
            <table class="m_-5162911287275600565table" width="620" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F9FB" style="background-color:#f9f9fb" role="presentation">
               <tbody>
                  <tr>
                     <td class="m_-5162911287275600565grey-border" style="padding:10px">
                        <table class="m_-5162911287275600565table-inner" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="background-color:#ffffff" role="presentation">
                           <tbody>
                              <tr>
                                 <td class="m_-5162911287275600565cell" align="center" style="text-align:center;padding-left:20px;padding-right:20px">
                                    <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                       <tbody>
                                          <tr>
                                             <td style="padding:20px 5px;text-align:center" aria-label="First1">
                                                <a border="0" title="First1">
                                                <img align="center" src="'.WEBLOGO.'" alt="First1" border="0" width="140" height="30" class="CToWUd">
                                                </a>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td bgcolor="#FFFFFF" width="100%" style="background-color:#ffffff">
                                    <table class="m_-5162911287275600565table" width="600" align="center" cellpadding="0" cellspacing="0" border="0" role="presentation">
                                       <tbody>
                                          <tr>
                                             <td align="left" style="width:100%">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" style="background-color:#ffffff" align="center">
                                                   <tbody>
                                                      <tr>
                                                         <td class="m_-5162911287275600565cell" style="padding:24px 20px 30px">
                                                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                               <tbody>
                                                                  <tr>
                                                                     <td style="padding:0">
                                                                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                                           <tbody>
                                                                              <tr>
                                                                                 <td style="font-family:Open-Sans,Arial;font-size:15px;font-weight:600;color:#2a2a33;line-height:22px">
                                                                                    "'.$message.'"
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                                 <td style="padding-top:13px;padding-bottom:20px">
                                                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                                       <tbody>
                                                                                          <tr>
                                                                                             <td style="font-family:Open-Sans,Arial;font-size:13px;line-height:19px;color:#666">Shared by<br><a href="mailto:'.$from_email.'" style="color:#006aff;text-decoration:none;font-weight:600" target="_blank">'.$from_email.'</a></td>
                                                                                          </tr>
                                                                                       </tbody>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                           </tbody>
                                                                        </table>
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td>
                                                                        <table width="560" cellpadding="0" cellspacing="0" border="0" class="m_-5162911287275600565table-inner" role="presentation">
                                                                           <tbody>
                                                                              <tr>
                                                                                 <td>
                                                                                    <table width="560px" cellpadding="0" cellspacing="0" border="0" role="presentation">
                                                                                       <tbody>
                                                                                          <tr>
                                                                                             <td style="padding-bottom:10px">
                                                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
                                                                                                   <tbody>
                                                                                                      <tr>
                                                                                                         <td>
                                                                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" role="presentation">
                                                                                                               <tbody>
                                                                                                                  <tr>
                                                                                                                     <td>
                                                                                                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                           <tbody>
                                                                                                                              <tr>
                                                                                                                                 <td style="background-image:url('.WEBURL.'/'.$DefaultPic.');background-size:cover;background-repeat:no-repeat;vertical-align:top;width:560px;background-position:center center;border-top-left-radius:3px;border-top-right-radius:3px;min-width:560px" height="350px" aria-label="Property photo">
                                                                                                                                    <a href="'.WEBURL.'/property-details/'.$MLSNumber.'/'.$link.'">
                                                                                                                                    </a>
                                                                                                                                 </td>
                                                                                                                              </tr>
                                                                                                                           </tbody>
                                                                                                                        </table>
                                                                                                                     </td>
                                                                                                                  </tr>
                                                                                                               </tbody>
                                                                                                            </table>
                                                                                                         </td>
                                                                                                      </tr>
                                                                                                      <tr>
                                                                                                         <td style="vertical-align:top;line-height:1;padding:7px 14px 12px;color:#2a2a33;border-bottom:4px solid #006aff;border-left:1px solid #ededee;border-right:1px solid #ededee;width:560px" valign="top">
                                                                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" role="presentation">
                                                                                                               <tbody>
                                                                                                                  <tr>
                                                                                                                     <td>
                                                                                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" role="presentation">
                                                                                                                           <tbody>
                                                                                                                              <tr>
                                                                                                                                 <td style="color:#2a2a33;font-family:Open-sans,Arial;text-overflow:ellipsis;white-space:nowrap;overflow:hidden!important;width:530px;max-width:530px">
                                                                                                                                    <a href="'.WEBURL.'/homes-for-sale/'.$MLSNumber.'/'.$link.'" style="color:#2a2a33;text-decoration:none">
                                                                                                                                       <table cellpadding="0" cellspacing="0">
                                                                                                                                          <tbody>
                                                                                                                                             <tr>
                                                                                                                                                <td style="font-size:26px;line-height:40px;font-weight:bold" aria-label="Property price $'.number_format($CurrentPrice,0).'">
                                                                                                                                                   $'.number_format($CurrentPrice,0).'
                                                                                                                                                </td>
                                                                                                                                                <td style="font-size:14px;line-height:21px;font-weight:600;padding-left:12px" aria-label="Property facts '.$BedsTotal.' bed '.$BathsTotal.' bath '.$TotalAreal.' square feet">
                                                                                                                                                   '.number_format($BedsTotal,0).' bd | '.number_format($BathsTotal,0).' ba | '.number_format($TotalAreal,0).' sqft
                                                                                                                                                </td>
                                                                                                                                             </tr>
                                                                                                                                          </tbody>
                                                                                                                                       </table>
                                                                                                                                    </a>
                                                                                                                                 </td>
                                                                                                                              </tr>
                                                                                                                           </tbody>
                                                                                                                        </table>
                                                                                                                     </td>
                                                                                                                  </tr>
                                                                                                                  <tr>
                                                                                                                     <td style="font-family:Open-sans,Arial;font-weight:600;font-size:16px;line-height:24px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden!important;width:530px;max-width:530px" aria-label="'.$PropertyAddress.'">
                                                                                                                        <a style="text-decoration:none;font-size:15px;color:#2a2a33" href="'.WEBURL.'/homes-for-sale/'.$MLSNumber.'/'.$link.'">
                                                                                                                        '.$SubCondoName.'
                                                                                                                        </a>
                                                                                                                     </td>
                                                                                                                  </tr>
                                                                                                                  <tr>
                                                                                                                     <td style="font-family:Open-sans,Arial;font-weight:600;font-size:16px;line-height:24px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden!important;width:530px;max-width:530px" aria-label="'.$PropertyAddress.'">
                                                                                                                        <a style="text-decoration:none;font-size:15px;color:#2a2a33" href="'.WEBURL.'/homes-for-sale/'.$MLSNumber.'/'.$link.'">
                                                                                                                        '.$PropertyAddress.'
                                                                                                                        </a>
                                                                                                                     </td>
                                                                                                                  </tr>
                                                                                                                  <tr>
                                                                                                                     <td style="color:#acacac;font-family:Open-Sans,Arial;font-size:14px;line-height:24px;font-weight:600;padding-top:5px" aria-label="{mlsDetailsLine1}">
                                                                                                                        MLS &zwnj;#&zwnj;'.$MLSNumber.'
                                                                                                                     </td>
                                                                                                                  </tr>
                                                                                                               </tbody>
                                                                                                            </table>
                                                                                                         </td>
                                                                                                      </tr>
                                                                                                   </tbody>
                                                                                                </table>
                                                                                             </td>
                                                                                          </tr>
                                                                                       </tbody>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                           </tbody>
                                                                        </table>
                                                                     </td>
                                                                  </tr>
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="m_-5162911287275600565cell" style="padding:20px;border-top:1px solid #ededee">
                                    <table width="100%" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" style="background-color:#ffffff" role="presentation">
                                       <tbody>
                                          <tr>
                                             <td style="font-family:Open-Sans,Arial;color:#75757a;font-size:14px;text-align:center;padding-bottom:18px">
                                                <span>'.WEBNAME.'.</span><br>
                                                <span>'.WEBADDRESS.'</span><br> 
                                                <span style="font-family: Helvetica, "Helvetica Neue", Arial, sans-serif;">&copy; '.date("Y").'</span>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="font-family:Open-Sans,Arial;font-size:14px;font-weight:600;text-align:center">
                                                <span>
                                                <a href="'.WEBURL.'/privacy" style="text-decoration: none; color: inherit;">Privacy policy</a>
                                                </span>
                                                <span>
                                                |
                                                <a href="'.WEBURL.'/terms" style="text-decoration: none; color: inherit;">Terms</a>
                                                </span>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>';     
     
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom(WEBMAIL, 'First1');
    $email->setSubject($subject);
    $splt = explode(',',$to_email);
    
    foreach($splt as $toEmail){
    if($toEmail!=''){
    $email->addTo($toEmail);
    }
    }
    
    $email->addContent("text/plain", 'You need to view this email in an HTML enabled browser.');
    $email->addContent("text/html", $emailBody);  
    $sendgrid = new \SendGrid(SENDGRID);
 
    try {  
    $response = $sendgrid->send($email);
    $code = $response->statusCode();
    
    if($code=='202'){ /** mail sent **/ 
    $restlArray=array('data'=>'Done'); 
    }else{ 
    $error=$response->body(); 
    $errors=json_decode($error);   
    $message=$errors->errors[0]->message;
    $restlArray=array('data'=>"Error sending email: ".$message);      
    }    
    
    }catch (\Exception $e) {  
    $message = $e->getMessage(); 
    $restlArray=array('data'=>"Error sending email: ".$message);   
    } 
    
    }else{
     $restlArray=array('data'=>"Not Found");
    }
    echo json_encode($restlArray); 
}


if(isset($_POST['from_email']) && isset($_POST['uniq_id']) && isset($_POST['to_email']) && isset($_POST['message'])){ 

     $uniq_id=filterThis($_POST['uniq_id'], $conn); 
     $from_email=filterThis(strtolower($_POST['from_email']), $conn); 
     $to_email=filterThis(strtolower($_POST['to_email']), $conn); 
     $message=filterThis($_POST['message'], $conn); 
     
     sendMail($conn,$uniq_id,$from_email,$to_email,$message);    
}
?>