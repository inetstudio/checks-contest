$(document).ready(function() {
  if ($('#receipts_modal').length > 0) {
    receiptModalApp = new Vue({
      el: '#receipts_modal',
    });
  }

  $('.check-table').on('click', 'a.check-moderate', function(event) {
    event.preventDefault();

    let button = $(this),
        url = button.attr('href'),
        reason = button.attr('data-reason');

    $('.checks-content.ibox-content').toggleClass('sk-loading');

    if (typeof reason !== typeof undefined && reason !== false) {
      swal.fire({
        title: 'Введите причину изменения статуса',
        input: 'text',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        showLoaderOnConfirm: true,
        preConfirm: (inputReason) => {
          if (inputReason === '') {
            return {
              dismiss: 'cancel'
            };
          }

          return moderate(url, inputReason);
        },
        allowOutsideClick: () => ! swal.isLoading()
      }).then((result) => {
        processModerateResponse(button, result);
      });
    } else {
      new Promise(function(resolve, reject) {
        let result = moderate(url, '');

        resolve(result);
      }).then((result) => {
        processModerateResponse(button, result);
      });
    }
  });

  $('.wrapper-content').on('click', '.show-receipts', function() {
    let url = $(this).attr('data-url');

    $('#receipts_modal').find('.ibox-content').removeClass('sk-loading');

    axios.get(url)
        .then(response => {
          $('#receipts_modal .modal-body .content').html(response.data);

          window.Admin.vue.stores['checks_contest_prizes'].commit('reset');

          receiptModalApp.$destroy();
          receiptModalApp = new Vue({
            el: '#receipts_modal',
          });

          $('#receipts_modal .modal-body .content .json-data').each(function () {
            let json = JSON.parse($(this).text());
            $(this).text(JSON.stringify(json, null, '\t'));
          });

          $('#receipts_modal').modal();
        })
        .catch(error => {
          swal.fire({
            title: 'Ошибка',
            text: 'При загрузке чека произошла ошибка',
            type: 'error',
          });
        });
  });
});

$(document).on('click', '#receipts_modal .save', function (event) {
  event.preventDefault();

  let form = $('#receipts_modal form');
  let formData = form.serializeArray();
  let container = $('#receipts_modal').find('.ibox-content');

  container.addClass('sk-loading');

  $.ajax({
    'url': form.attr('action'),
    'type': form.attr('method'),
    'data': formData,
    'dataType': 'json',
    'success': function(data) {
      container.removeClass('sk-loading');

      let receiptId = _.find(formData, {'name':'check_id'}).value;
      $('.check-table').find('.receipt-id').filter(function() {
        return $(this).text() === receiptId;
      }).closest('tr').find('.receipt-prizes').html(data.prizes);

      $('#receipts_modal').modal('hide');
    }
  });
});

function moderate(url, inputReason)
{
  const data = {
    receipt_data: {
      statusReason: inputReason
    }
  };

  return axios.post(url, data)
      .then(response => {
        $('.checks-content.ibox-content').toggleClass('sk-loading');

        if (response.status !== 200) {
          throw new Error(response.statusText);
        }

        return response.data;
      })
      .catch(error => {
        $('.checks-content.ibox-content').toggleClass('sk-loading');

        swal.fire({
          title: 'Ошибка',
          text: 'При модерации произошла ошибка',
          type: 'error',
        });
      });
}

function processModerateResponse(button, result)
{
  result = _.get(result, 'value', result);

  if (result.dismiss === 'cancel') {
    $('.checks-content.ibox-content').toggleClass('sk-loading');

    return;
  }

  if (result.success === true) {
    button.closest('tr').find('.receipt-status').html(result.status);
    button.closest('tr').find('.receipt-prizes').html(result.prizes);
    button.closest('td').html(result.moderation);

    swal.fire({
      title: 'Статус изменен',
      type: 'success',
    });
  } else {
    swal.fire({
      title: 'Ошибка',
      text: 'При модерации произошла ошибка',
      type: 'error',
    });
  }
}
