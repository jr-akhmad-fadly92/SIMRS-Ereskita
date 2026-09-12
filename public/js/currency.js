<!-- Pemisah Ribuan -->
    <script type="text/javascript">
    function format_currency( input ){
   "use strict";

   // get input value and clean up characters except numbers
   var angka = input.val().replace( /[^0-9]+/g, "" );

   // get input length, how much character there
   var pjg = angka.length;

   // if there are less than 3 characters then, ... etc. I think this is a traditional and dirty code. hahaha.
   if( pjg < 3 ){
      input.val( angka.substring( 0, pjg % 3 ) + angka.substring( pjg % 3 ) );
   }
   else if( pjg == 3 ) {
      input.val( angka.substring( 0, 3 ) );
   }
   else if( pjg < 6 ){
      input.val( angka.substring( 0, pjg % 3 ) + "." + angka.substring( pjg % 3 ) );
   }
   else if( pjg == 6 ) {
      input.val( angka.substring( 0, 3 ) + "." + angka.substring( 3, 6 ) );
   }
   else if( pjg < 9 ){
      input.val( angka.substring( 0, pjg % 3 ) + "." + angka.substring( pjg % 3, 3 + ( pjg % 3 ) ) + "." + angka.substring( 3 + ( pjg % 3 ) ) );
   }
   else if( pjg == 9 ){
      input.val( angka.substring( 0, 3 ) + "." + angka.substring( 3, 6 ) + "." + angka.substring( 6, 9 ) );
}
   else if( pjg < 12 ){
      input.val( angka.substring( 0, pjg % 3) + "." + angka.substring( pjg % 3, 3 + ( pjg % 3 ) ) + "." + angka.substring( 3 + ( pjg % 3 ), 6 + ( pjg % 3 ) ) + "." + angka.substring( 6 + ( pjg % 3 ) ) );
   }
   else if( pjg == 12 ){
      input.val( angka.substring( 0, 3 ) + "." + angka.substring( 3, 6 ) + "." + angka.substring( 6, 9 ) + "." + angka.substring( 9, 12 ) );
   }
}

// document ready
$( function() {
   "use strict";

   // When document is ready, I put the cursor into the input automatically. Make user easier to navigate.
   // $( "#fc" ).focus();

   // When user type something in the input field, then ...
   $( "#fc" ).bind( "keyup", function( e ) {

      // I only allow numbers, backspace, and F5 button work on the field when it's pressed by user
      if ( ( e.which > 47 && e.which < 58 ) || e.which === 8 || e.which === 116 ){

         // I call the function, boom!
         format_currency( $( this ) );
      }

      // Anyelse button ? Sorry :p
      else {
         e.preventDefault();
      }
   });
});
</script>