$(document).ready(function() {
  $('.check-table').on('click', 'a.check-moderate', function(event) {
    event.preventDefault();

    let button = $(this),
        url = button.attr('href');

    $('.checks-content.ibox-content').toggleClass('sk-loading');

    $.ajax({
      url: url,
      method: 'POST',
      dataType: 'json',
      success: function(data) {
        $('.checks-content.ibox-content').toggleClass('sk-loading');

        if (data.success === true) {
          button.closest('tr').children('td').eq(1).html(data.status);
          button.closest('td').html(data.moderation);

          swal({
            title: 'Статус изменен',
            type: 'success',
          });
        } else {
          swal({
            title: 'Ошибка',
            text: 'При модерации произошла ошибка',
            type: 'error',
          });
        }
      },
    });
  });

  if ($('#checkForm').length > 0) {
    let formApp = new Vue({
      el: '#checkForm',
    });
  }

  $('.wrapper-content').on('click', '.show-receipts', function() {
    let url = $(this).attr('data-url');

    $('#receipts_modal').find('.ibox-content').removeClass('sk-loading');

    $.ajax({
      url: url,
      method: 'GET',
      dataType: 'html',
      success: function(data) {
        $('#receipts_modal .modal-body .content').html(data);

        let receiptModalApp = new Vue({
          el: '#receipts_modal',
        });

        $('#receipts_modal').modal();
      },
    });
  });
});

$(document).on('click', '#receipts_modal .save', function (event) {
  event.preventDefault();

  let form = $('#receipts_modal form');
  let data = form.serializeArray();
  let container = $('#receipts_modal').find('.ibox-content');

  container.addClass('sk-loading');

  $.ajax({
    'url': form.attr('action'),
    'type': form.attr('method'),
    'data': data,
    'dataType': 'json',
    'success': function(data) {
      container.removeClass('sk-loading');

      $('#receipts_modal').modal('hide');
    }
  });
});
