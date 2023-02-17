<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

    <title>email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->
    
    <style type="text/css">
    
        /*table td {border: 1px solid #DDDDDD;} */
    
        .ReadMsgBody { width: 100%; background-color: #F1F1F1; }
        .ExternalClass { width: 100%; background-color: #F1F1F1; }
        body { width: 100%; background-color: #f6f6f6; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; font-family: Arial, Times, serif }
        table { border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        *[class*="mobileOn"] { display: none !important; max-height: none !important; }
        
        @-ms-viewport{ width: device-width; }
        
        @media only screen and (max-width: 639px){
        .wrapper{ width:100%;  padding: 0 !important; }
        }    
        @media only screen and (max-width: 480px){ 
        .centerClass{ margin:0 auto !important; } 
        .imgClass{width:100% !important; height:auto;}    
        .wrapper{ width:320px;  padding: 0 !important; }      
        .container{ width:300px;  padding: 0 !important; }
        .mobile{ width:300px; display:block; padding: 0 !important; text-align:center; }
        .mobile50{ width:300px; padding: 0 !important; text-align:center; }
        *[class="mobileOff"] { width: 0px !important; display: none !important; }
        *[class*="mobileOn"] { display: block !important; max-height: none !important; }
        }
    
    </style>
    
    <!--[if gte mso 15]>
    <style type="text/css">
        table { font-size:1px; line-height:0; mso-margin-top-alt:1px;mso-line-height-rule: exactly; }
        * { mso-line-height-rule: exactly; }
    </style>
    <![endif]-->    

</head>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" yahoo="fix" style="background-color:#F2F2F2; font-family:Arial,serif;margin:0;padding:0;min-width: 100%; -webkit-text-size-adjust:none;-ms-text-size-adjust:none;">

    <!--[if !mso]><!-- -->
    <img style="min-width:640px;display:block;margin:0;padding:0" class="mobileOff" width="640" height="1" src="https://s14.postimg.org/7139vfhzx/spacer.gif">
    <!--<![endif]-->

    <!-- Start Background -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="100%" valign="top" align="center">
              
<!-- Start Wrapper  -->
<table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#377700">
    <tr>
        <td height="10" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
    </tr>
    <tr>
        <td align="center">
                  
            <!-- Start Container  -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                <tr>
                    <td width="300" class="mobile" style="font-size:12px; line-height:18px;">
                        <strong>GRACIAS POR TU CONSULTA.</strong>
                    </td>
                    <td width="300" align="right" class="" >

                    </td>
                </tr>
            </table>
            <!-- Start Container  -->                   
                  
        </td>
    </tr>
    <tr>
        <td height="10" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
    </tr>                        
</table> 
<!-- End Wrapper  -->  

<!-- Start Wrapper TITULO DATOS DE CONTACTO  -->
<table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
    <tr>
        <td height="20" style="font-size:10px; line-height:10px;">  </td><!-- Spacer -->
    </tr>
    <tr>
        <td align="center">
                  
            <!-- Start Container  -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">

                <tr>
                    <td width="600" class="mobile" style="font-size:12px; line-height:18px;">
                        <strong> DATOS DE CONTACTO</strong>
                    </td>
                </tr>

 
            </table>
            <!-- Start Container  -->                   
                  
        </td>
    </tr>
                        
</table> 
<!-- End Wrapper  --> 



<!-- Start Wrapper  DATOS DE CONTACTO --> 
<table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">

    <tr>
        <td align="center">
                  
            <!-- Start Container  -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                
                <tr>
                    <td height="10" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
                </tr>

                <tr>
                    <td width="100" class="mobile" style="font-size:12px; line-height:18px;">
                        <strong>Nombre: </strong> {{ $nombre }}<br>
                        
                        @isset ($telefono)
                            <strong>Teléfono: </strong> {{ $telefono }}<br>                            
                        @endisset
                        
                    </td>
                    <td width="500" class="mobile" style="font-size:12px; line-height:18px;">
                        <strong>Email: </strong> {{ $email }}<br>
                    </td>
                </tr>

                <tr>
                    <td width="640" class="mobile" style="font-size:12px; line-height:18px;">
                        <strong>Comentario: </strong> {{ $comentario }}<br><br> <br>
                    </td>
                </tr>
            
            </table>
            <!-- Start Container  -->                   
                  
        </td>
    </tr>
                     
</table> 
<!-- End Wrapper  -->  
      

<!-- Start Wrapper  FOOTER -->
<table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
    <tr>
        <td height="30" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
    </tr>
    <tr>
        <td align="center">
                  
            <!-- Start Container  -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                <tr>
                    <td width="300" class="mobile" style="font-size:12px; line-height:18px;">
                       
                    <strong>saintjosephweb.com.ar<br></strong>
                    <br>

                      <a href="mailto:info@saintjosephweb.com.ar" style="color: #3f3f3f;">info@saintjosephweb.com.ar</a><br>
                      <a href="https://saintjosephweb.com.ar" style="color: #3f3f3f;">saintjosephweb.com.ar</a><br>

                    </td>

                    <td width="300" align="right" class="" style="font-size:12px;"> 

                      <a href="http://www.saintjosephweb.com.ar">
                         <img src="https://www.saintjosephweb.com.ar/images/logo.png" width="120" style="float:right;margin:0; padding:0; border:none; display:block;" border="0" alt="" /> 
                      </a>

                    </td>
                </tr>
            </table>
            <!-- Start Container  -->                   
                  
        </td>
    </tr>
    <tr>
        <td height="10" style="font-size:10px; line-height:10px;"> </td><!-- Spacer -->
    </tr>                        
</table> 
<!-- End Wrapper  -->  


<!-- Start Wrapper TITULO DATOS DE CONTACTO  -->
<table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
    <tr>
        <td height="20" style="font-size:10px; line-height:10px;">  </td><!-- Spacer -->
    </tr>
    <tr>
        <td align="center">
                  
            <!-- Start Container  -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">

                <tr>
                    <td width="600" class="mobile" style="font-size:12px; line-height:18px;">
                        Este e-mail es enviado por saintjosephweb.com.ar Todos los derechos reservados.<br><br>
                    </td>
                </tr>

 
            </table>
            <!-- Start Container  -->                   
                  
        </td>
    </tr>
                        
</table> 
<!-- End Wrapper  --> 
            
            </td>
        </tr>
    </table>
    <!-- End Background -->
    
</body>
</html>