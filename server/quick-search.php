<?php
include 'connect.php';
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
error_reporting(0);
 
if(isset($_POST['keyword'])){ 
     
     $keyword=mysqli_real_escape_string($conn,$_POST['keyword']);
     /**
     (SELECT City, Development, DevelopmentName, 'city' as type FROM properties WHERE City LIKE '%$keyword%' GROUP BY(City)) 
               UNION ALL 
     **/
     $query = "(SELECT City, Development, PostalCode as DevelopmentName, 'postal_code' as type FROM properties WHERE Status='Active' AND PostalCode LIKE '%$keyword%' GROUP BY(PostalCode))
               UNION ALL (SELECT City, Development, DevelopmentName, 'community' as type FROM properties WHERE Status='Active' AND Development LIKE '%$keyword%' OR DevelopmentName LIKE '%$keyword%' GROUP BY Development, DevelopmentName) 
               UNION ALL (SELECT City, Development, PropertyAddress as DevelopmentName, 'streetname' as type FROM properties WHERE Status='Active' AND PropertyAddress LIKE '%$keyword%' GROUP BY(StreetName)) LIMIT 12";
     $srchRslt = mysqli_query($conn,$query) or die(mysqli_error($conn));
     $rsltFoumd = mysqli_num_rows($srchRslt);
     
     if($rsltFoumd>0){
        while($row = mysqli_fetch_assoc($srchRslt)){
        extract($row);
        
        $restlArray[]=array('data'=>'Done', 'City'=>$City, 'Development'=>$Development, 'DevelopmentName'=>$DevelopmentName, 'table'=>$type);
        }
        
        echo json_encode($restlArray);
       
     }else{
        $restlArray[]=array('data'=>'Error: not found');
        echo json_encode($restlArray);
     }
     
}else{
     $restlArray[]=array('data'=>'Error: missing required feild');
     echo json_encode($restlArray);
}
?>