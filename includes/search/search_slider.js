jQuery(document).ready(function($) {
  var max =  $("#meta_price_max").val();
  var choice_price_min = $("#choice_price_min").val();
  var choice_price_max = $("#choice_price_max").val();  
  if( typeof choice_price_min === 'undefined' || typeof choice_price_min === 'undefined' )
     {
       choice_price_min = 0;
       choice_price_max = max;      
     }
  $("#multidealer_meta_price").slider({
     range: true,
     step: 100, 
     min: 0, 
     max: max, 
     values: [choice_price_min, choice_price_max], 
     slide: function(event, ui) {
        $("#meta_price").val(ui.values[0] + " - " + ui.values[1]);}
  });
  var $sliderMax  = $("#meta_price_max2");
  var $choiceMin = $("#choice_price_min2")
  var $choiceMax = $("#choice_price_max2")
  var maxVal =  $sliderMax .val();
  var choiceMinVal = $choiceMin.val();
  var choiceMaxVal = $choiceMax.val(); 
  if( typeof choiceMinVal === 'undefined' || typeof choiceMaxVal === 'undefined' )
     {
       choiceMinVal = 0;
       choiceMaxVal = maxVal;      
     }
  $("#multidealer_meta_price2").slider({
     range: true,
     step: 100, 
     min: 0, 
     max: maxVal, 
     values: [choiceMinVal, choiceMaxVal], 
     slide: function(event, ui) {
        $("#meta_price2").val(ui.values[0] + " - " + ui.values[1]);}
  }); 
});