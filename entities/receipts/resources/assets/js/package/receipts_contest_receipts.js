import Swal from 'sweetalert2';

export let receipts = {
  init: function () {
    $(document).ready(function () {
      let $moderationTable = $('#receipts_contest_receipts table');

      $moderationTable.on('click', 'a.receipt-moderate', function (event) {
        event.preventDefault();

        let button = $(this),
            url = button.attr('href'),
            reason = button.attr('data-reason');

        $('#receipts_contest_receipts .ibox-content').toggleClass('sk-loading');

        let data = {
          id: button.data('id'),
          status_id: button.data('status_id'),
        };

        if (typeof reason !== typeof undefined && reason !== false) {
          Swal.fire({
            title: 'Введите причину изменения статуса',
            input: 'select',
            inputOptions: {
              'Дата покупки не соответствует срокам проведения акции': 'Дата покупки не соответствует срокам проведения акции',
              'Отсутствует(ют) обязательный(ые) товар(ы)': 'Отсутствует(ют) обязательный(ые) товар(ы)',
              'Отсутствует(ют) дополнительный(ые) товар(ы)': 'Отсутствует(ют) дополнительный(ые) товар(ы)',
              'Отсутствует(ют) товар(ы), участвующий(ие) в акции': 'Отсутствует(ют) товар(ы), участвующий(ие) в акции',
              'Дубликат': 'Дубликат',
              'Отсутствует QR-код': 'Отсутствует QR-код',
              'Отсутствует фото чека': 'Отсутствует фото чека',
              'Присутствует только QR-код': 'Присутствует только QR-код',
              'Место покупки не участвует в розыгрыше': 'Место покупки не участвует в розыгрыше',
              'Чек невозможно прочитать': 'Чек невозможно прочитать',
              'Чек не прошел валидацию в ФНС': 'Чек не прошел валидацию в ФНС',
              'Загрузка до начала конкурса': 'Загрузка до начала конкурса',
              'Загрузка после окончания конкурса': 'Загрузка после окончания конкурса',
              'Отсутствует юридическая информация': 'Отсутствует юридическая информация'
            },
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

              data.receipt_data = {
                statusReason: inputReason
              };

              return moderate(url, data);
            },
            allowOutsideClick: () => ! Swal.isLoading()
          }).then((result) => {
            processModerateResponse(result);
          });
        } else {
          new Promise(function(resolve, reject) {
            let result = moderate(url, data);

            resolve(result);
          }).then((result) => {
            processModerateResponse(result);
          });
        }
      });

      $('#receipts_contest_receipts').on('click', '.show-receipt', function(event) {
        window.Admin.vue.helpers.initComponent('receipts_contest_receipts', 'ReceiptsContestReceiptForm', {});

        let url = $(this).attr('data-url');

        window.waitForElement('#receipts_contest_receipt_form_modal', function() {
          axios.get(url)
              .then(response => {
                window.Admin.vue.stores['receipts_contest_receipts'].commit('setReceipt', response.data);

                $('#receipts_contest_receipt_form_modal').modal();
              })
              .catch(error => {
                showError('При загрузке чека произошла ошибка');
              });
        });
      });
    });

    function moderate(url, data) {
      return axios.post(url, data)
          .then(response => {
            $('#receipts_contest_receipts .ibox-content').toggleClass('sk-loading');

            if (response.status !== 200) {
              throw new Error(response.statusText);
            }

            return response.data;
          })
          .catch(error => {
            $('#receipts_contest_receipts .ibox-content').toggleClass('sk-loading');

            showError('При модерации произошла ошибка');
          });
    }

    function processModerateResponse(result) {
      result = _.get(result, 'value', result);

      if (result.dismiss === 'cancel') {
        $('#receipts_contest_receipts .ibox-content').toggleClass('sk-loading');

        return;
      }

      if (result.success === true) {
        result.items.forEach(function (item) {
          let row = $('#receipt_row_'+item.id);

          for (let column in item) {
            if (item.hasOwnProperty(column)) {
              row.find('.receipt-'+column).html(item[column]);
            }
          }
        });

        Swal.fire({
          title: 'Статус изменен',
          icon: 'success'
        });
      } else {
        showError('При модерации произошла ошибка');
      }
    }

    function showError(text) {
      Swal.fire({
        title: 'Ошибка',
        text: text,
        icon: 'error',
      });
    }
  }
};
