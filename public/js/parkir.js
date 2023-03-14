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

            mainTable.DataTable();
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
    getAll()
    mainTable.DataTable();
});
