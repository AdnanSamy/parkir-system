const mainTable = $('#main_table')
const modalParkir = $('#modalParkir')
const nomorPolisi = $('#nomorPolisi')
const saveType = $('#saveType')
const dataId = $('#dataId')
const INSERT_TYPE = 'insert-type'
const UPDATE_TYPE = 'update-type'
const btnNew = $('#btnNew')
const save = $('#save')
const kodeUnik = $('#kodeUnik')
const biayaParkir = $('#biayaParkir')
const biayaParkirValue = $('#biayaParkirValue')
const keluar = $('#keluar')
const dateRange = $('#dateRange')
var user = null

const getUser = () => {
    $.ajax({
        type: "get",
        url: `/api/get-user`,
        success: function (response) {
            const { data } = response;

            user = { ...data }

            getAll()
        }
    });
}

const createTable = function () {
    console.log('USER -> ', user);
    if (user) {
        if (user.roles.some(e => e.name == 'admin')) {
            mainTable.DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        } else {
            mainTable.DataTable();
        }
    }
}

dateRange.daterangepicker({
    timePicker: true,
    autoUpdateInput: false,
    // startDate: moment().startOf('hour'),
    // endDate: moment().startOf('hour'),
    locale: {
        format: 'YYYY-MM-DD hh:mm:ss'
    }
});
dateRange.on('apply.daterangepicker', function (ev, picker) {
    const startDate = picker.startDate.format('YYYY-MM-DD hh:mm:ss')
    const endDate = picker.endDate.format('YYYY-MM-DD hh:mm:ss')

    $(this).val(startDate + ' - ' + endDate);
    $.ajax({
        type: "get",
        url: `/api/parkir/${startDate}/${endDate}`,
        success: function (response) {
            console.log('RESPONSE GET ALL -> ', response);
            const { data } = response;

            mainTable.DataTable().destroy();

            mainTable.find('tbody').html('')
            data.forEach((e, i) => {
                mainTable.find("tbody").append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${e.kode_unik}</td>
                        <td>${e.nomor_polisi}</td>
                        <td>${e.created_at}</td>
                        <td>
                            <button class="btn btn-warning" onclick="getData(${e.id
                    })">Hitung Parkir</button>
                            <button class="btn btn-danger" onclick="deleteData(${e.id
                    })">Delete</button>
                        </td>
                    </tr>
                `);
            });

            createTable();
        }
    });
});
dateRange.on('cancel.daterangepicker', function (ev, picker) {
    //do something, like clearing an input
    dateRange.val('');
});

const openModalParkir = function () {
    const insertElement = $(`.${INSERT_TYPE}`)
    const updateElement = $(`.${UPDATE_TYPE}`)

    if (saveType.val() == INSERT_TYPE) {
        insertElement.removeClass('d-none')
        updateElement.addClass('d-none')
    } else {
        insertElement.addClass('d-none')
        updateElement.removeClass('d-none')
    }

    modalParkir.modal('show')
}

const keluarParkir = function () {
    $.ajax({
        type: "put",
        url: "/api/parkir/keluar",
        data: {
            biaya_parkir: biayaParkirValue.val(),
            id: dataId.val(),
        },
        success: function (response) {
            const { message } = response

            if (message == 'success') {
                location.reload()
            }
        }
    });
}

const getData = function (id) {
    $.ajax({
        type: "get",
        url: `/api/parkir/${id}`,
        success: function (response) {
            const { data, biaya_parkir } = response

            saveType.val(UPDATE_TYPE)

            dataId.val(data.id)
            nomorPolisi.val(data.nomor_polisi)
            kodeUnik.text(data.kode_unik)
            biayaParkir.text('Rp.' + biaya_parkir.toLocaleString())
            biayaParkirValue.val(biaya_parkir)

            openModalParkir()

            console.log('RESPONSE GET ONE -> ', response);
        }
    });
}

const insertDate = function () {
    $.ajax({
        type: "post",
        url: "/api/parkir",
        data: {
            nomorPolisi: nomorPolisi.val(),
        },
        success: function (response) {
            const { message } = response

            if (message == 'success') {
                location.reload()
            }
        }
    });
}

const getAll = function () {
    $.ajax({
        type: "get",
        url: "/api/parkir",
        success: function (response) {
            console.log('RESPONSE GET ALL -> ', response);
            const { data } = response;

            mainTable.DataTable().destroy();

            data.forEach((e, i) => {
                mainTable.find("tbody").append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${e.kode_unik}</td>
                        <td>${e.nomor_polisi}</td>
                        <td>${e.created_at}</td>
                        <td>
                            <button class="btn btn-warning" onclick="getData(${e.id
                    })">Hitung Parkir</button>
                            <button class="btn btn-danger" onclick="deleteData(${e.id
                    })">Delete</button>
                        </td>
                    </tr>
                `);
            });

            createTable();
        }
    });
}

keluar.click(function (e) {
    keluarParkir()
});

save.click(function (e) {
    insertDate()
});

btnNew.click(function (e) {
    saveType.val(INSERT_TYPE)
    openModalParkir()
});


$(document).ready(function () {
    getUser()
    createTable();
});
