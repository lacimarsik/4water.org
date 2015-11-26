/* This function adjust columns in each row to have equal heights
 * 
 * Can be applied in situation when divs with "row_class" CSS class hold 
 * divs with "col_class" CSS class 
 * 
 * See e.g. parallax_one_which_style_section.php for example of usage
 * */
function align_col_heights(row_class, col_class, min_width) {   
  var rows = $('.' + row_class);
  var rows_len = rows.length;
  for (var i = 0; i < rows_len; i++) {               
    //reset the height to initial - heights will now scale as needed 
    var cols = rows.eq(i).find('.' + col_class);
    cols.css({
      'height': 'initial'
    });
    
    if ($(window).width() < min_width) continue;

    //now get the maximum height
    var boxes_len = cols.length;
    var max_height = 0;
    for (var j = 0; j < boxes_len; j++) {
      var h = cols.eq(j).outerHeight();
      max_height = Math.max(max_height, h);
    }

    //set all heights to the found max
    cols.css({
      'height': max_height + 'px'
    });
  }
};