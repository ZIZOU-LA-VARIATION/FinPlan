
  document.addEventListener('DOMContentLoaded', function () {
    var deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
    deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var accountId = button.getAttribute('data-account-id');
      var form = document.getElementById('deleteAccountForm');
      form.action = '/accounts/' + accountId;
    });
  });


