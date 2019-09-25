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

    $.ajax({
      url: url,
      method: 'GET',
      dataType: 'html',
      success: function(data) {
        $('#receipts_modal .modal-body').html(data);

        $('#receipts_modal').modal();
      },
    });
  });
});
