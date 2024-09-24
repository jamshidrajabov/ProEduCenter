import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
$(document).ready(function() {
    $('#example2').DataTable({
        language: {
            "sEmptyTable": "Ma'lumotlar mavjud emas",
            "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
            "sInfoEmpty": "Showing 0 to 0 of 0 entries",
            "sInfoFiltered": "(filtered from _MAX_ total entries)",
            "sLengthMenu": "_MENU_ entries",
            "sLoadingRecords": "Yuklanmoqda...",
            "sProcessing": "Qayta ishlanmoqda...",
            "sSearch": "Qidirish:",
            "sZeroRecords": "Hech qanday mos keluvchi yozuvlar topilmadi",
            "oPaginate": {
                "sFirst": "Birinchisi",
                "sLast": "Oxirgi",
                "sNext": "Keyingi",
                "sPrevious": "Oldingi"
            }
        }
    });
});

