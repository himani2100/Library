function check_all()
{
   var checked = document.forms[1], num = 0;

   if(checked[1].checked)
   {
      for(num=0; num < checked.length; num++)
      {
         checked[num].checked=true;
      }
   }
   else
   {
      for(num=0; num < checked.length; num++)
      {
         checked[num].checked=false;
      }
   }
}
