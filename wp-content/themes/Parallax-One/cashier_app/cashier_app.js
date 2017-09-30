/**
 * Cashier app - prototype (JS part)
 */

if (typeof jQuery === 'undefined') {
  throw new Error('Cashier app requires jQuery')
}

function getCounterId(buttonId) {
  return buttonId.substr(0, buttonId.indexOf('-'));
}

$(document).ready(function() {
  $('.js-plus').click(function () {
    var buttonId = $(this).attr('id');
    var counterId = getCounterId(buttonId)
    $('#' + counterId).val(function (i, val) {
      $.ajax({
        url: './index.php',
        type: 'POST',
        data: {'cashier': true, 'increment': true },
        success: function (data) {

        }
      });
      return +val + 1;
    });
  })

  $('.js-minus').click(function () {
    var buttonId = $(this).attr('id');
    var counterId = getCounterId(buttonId)
    $('#' + counterId).val(function (i, val) {
      $.ajax({
        url: './index.php',
        type: 'POST',
        data: {'cashier': true, 'decrement': true },
        success: function (data) {

        }
      });
      if (val > 0) {
        return +val - 1;
      } else {
        return 0;
      }
    });
  })
})