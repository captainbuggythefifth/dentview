/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


    function form_validate(fld)
     {
         var illegalChars = /[\|&;\$%@"<>\(\)\+]/;
         
         if(illegalChars.test(fld.value))
         {
                 
             //alert("ileegdsgds ");
             $('.errors').animate($('.errors').show('slow'),5);
             fld.style.background="yellow";
             return false;
         }
         else
             {
                 
             fld.style.background="";
             return true;
             }
         
     }
