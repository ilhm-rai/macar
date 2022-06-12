function bersihkan() {
    $( "#no_plat" ).val( "" );
    $( "#nama_mobil" ).val( "" );
    $( "#cc" ).val( "" );
    $( "#warna" ).val( "" );
    $( "#tahun" ).val( "" );
    $( "#foto" ).val( "" );
    $( ".img-preview" ).attr( "src", "assets/img/icons8_camera_60px.png" );
}

function tampil( page = 1 ) {
    var html = "";
    $.ajax( {
        type: "GET",
        data: `halaman=${page}`,
        url: "tampil.php",
        dataType: "json",
        success: function ( response ) {
            for ( let i = 0; i < response['data'].length; i++ ) {
                html +=
                    `<tr>
                    <td class="align-left">${response['data'][i].no_plat}</td>
                    <td class="align-left">${response['data'][i].nama_mobil}</td>
                    <td>${response['data'][i].jenis}</td>
                    <td>${response['data'][i].tahun}</td>
                    <td>${response['data'][i].cc} CC</td>
                    <td>${response['data'][i].warna}</td>
                    <td><img src="assets/img/${response['data'][i].foto}" alt="${response['data'][i].nama_mobil}" style="width: 100px;"></td>
                    <td>${response['data'][i].aksi}</td>
                </tr>`;
            }
            $( "#carData" )[0].innerHTML = html;
            $( "#pagination" )[0].innerHTML = response['pagination'];

            $( "#pageBack" ).on( 'click', function ( e ) {
                e.preventDefault();
                tampil( $( this ).data( 'halaman' ) );
            } );

            $( "#pagination" ).on( "click", ".page", function ( e ) {
                e.preventDefault();
                tampil( $( this ).data( 'halaman' ) );
            } );

            $( "#pageNext" ).on( 'click', function ( e ) {
                e.preventDefault();
                tampil( $( this ).data( 'halaman' ) );
            } );
        }
    } );
}

function hapus( plat ) {
    $.ajax( {
        type: "GET",
        data: `no_plat=${plat}`,
        url: "hapus.php",
        dataType: "json",
        success: function ( data ) {
            for ( let i = 0; i < data.length; i++ ) {
                alert( data[i].pesan );
                if ( data[i].id_pesan > 0 ) {
                    tampil();
                }
            }
        }
    } );
}

function login( data ) {
    const formData = new FormData( data );
    $.ajax( {
        url: 'cekLogin.php',
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function ( data ) {
            alert( data[0].pesan );
            if ( data[0].id_pesan == 1 ) {
                window.location.href = 'index.php';
            }
        }
    } );
}

function register( data ) {
    const formData = new FormData( data );
    $.ajax( {
        url: 'prosesRegistrasi.php',
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function ( data ) {
            alert( data[0].pesan );
            if ( data[0].id_pesan == 1 ) {
                window.location.href = 'login.php';
            }
        }
    } );

}

function tampilUbah( plat ) {
    $.ajax( {
        type: "GET",
        data: `no_plat=${plat}`,
        url: "tampilUbah.php",
        dataType: "json",
        success: function ( data ) {
            for ( let i = 0; i < data.length; i++ ) {
                $( "#no_plat" ).val( `${data[i].no_plat}` );
                $( "#no_plat_lama" ).val( `${data[i].no_plat}` );
                $( "#nama_mobil" ).val( `${data[i].nama_mobil}` );
                $( "#cc" ).val( `${data[i].cc}` );
                $( "#warna" ).val( `${data[i].warna}` );
                $( "#tahun" ).val( `${data[i].tahun}` );
                $( "#foto_lama" ).val( `${data[i].foto}` );
                $( `select#jenis_mobil option[value='${data[i].id_jenis}']` ).attr( "selected", "selected" );
                $( ".img-preview" ).attr( "src", `assets/img/${data[i].foto}` );
            }
        }
    } );
}

function cari( keyword ) {
    var html = "";
    $.ajax( {
        type: "GET",
        data: `keyword=${keyword}`,
        url: "tampil.php",
        dataType: "json",
        success: function ( response ) {
            for ( let i = 0; i < response['data'].length; i++ ) {
                html +=
                    `<tr>
                    <td class="align-left">${response['data'][i].no_plat}</td>
                    <td class="align-left">${response['data'][i].nama_mobil}</td>
                    <td>${response['data'][i].jenis}</td>
                    <td>${response['data'][i].tahun}</td>
                    <td>${response['data'][i].cc} CC</td>
                    <td>${response['data'][i].warna}</td>
                    <td><img src="assets/img/${response['data'][i].foto}" alt="${response['data'][i].nama_mobil}" style="width: 100px;"></td>
                    <td>${response['data'][i].aksi}</td>
                </tr>`;
            }
            $( "#carData" )[0].innerHTML = html;
            $( "#pagination" )[0].innerHTML = response['pagination'];

            $( "#pageBack" ).on( 'click', function ( e ) {
                e.preventDefault();
                tampil( $( this ).data( 'halaman' ) );
            } );

            $( "#pagination" ).on( "click", ".page", function ( e ) {
                e.preventDefault();
                tampil( $( this ).data( 'halaman' ) );
            } );

            $( "#pageNext" ).on( 'click', function ( e ) {
                e.preventDefault();
                tampil( $( this ).data( 'halaman' ) );
            } );
        }
    } );
}

var ubah = false;

$( "document" ).ready( function () {
    $( "#loginForm" ).on( "submit", function ( e ) {
        e.preventDefault();
        login( this );
    } );

    $( "#registerForm" ).on( "submit", function ( e ) {
        e.preventDefault();
        register( this );
    } );

    $( "#carData" ).on( "click", ".btn-hapus", function () {
        var cnfrm = confirm( 'Apa kamu yakin akan menghapus data ini?' );
        if ( cnfrm == true ) {
            var plat = $( this ).data( "plat" );
            hapus( plat );
        }
    } );

    $( "#carData" ).on( "click", ".btn-ubah", function () {
        var plat = $( this ).data( "plat" );
        tampilUbah( plat );
        ubah = true;
    } );

    $( "#keyword" ).on( "keyup keypress change", function () {
        var keyword = $( this ).val();
        cari( keyword );
    } );

    $( "#addCarForm" ).on( "submit", function ( e ) {
        e.preventDefault();
        var alamat = '';
        const formData = new FormData( this );
        if ( ubah == true ) {
            alamat = 'ubah.php';
        } else {
            alamat = 'simpan.php';
        }
        $.ajax( {
            url: alamat,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function ( data ) {
                for ( let i = 0; i < data.length; i++ ) {
                    alert( data[i].pesan );
                    if ( data[i].id_pesan > 0 ) {
                        tampil();
                        bersihkan();
                        ubah = false;
                    }
                }
            }
        } );
    } );

    $( "#addCarForm" ).on( "reset", function ( e ) {
        e.preventDefault();
        bersihkan();
        ubah = false;
    } );

    $( "#foto" ).on( "change", function () {
        const picture = document.querySelector( "#foto" );
        const imgPreview = document.querySelector( ".img-preview" );

        const filePicture = new FileReader();
        filePicture.readAsDataURL( picture.files[0] );

        filePicture.onload = function ( e ) {
            imgPreview.src = e.target.result;
        };
    } );
} );
