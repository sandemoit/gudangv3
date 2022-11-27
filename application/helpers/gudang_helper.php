<?php
function is_logged_in() //ini untuk mengecek apakah user sudah login atau belum
{
    $ci = get_instance();
    $ci->session->userdata('email') || redirect('auth');
}

function set_pesan($message, $tipe = true) //ini untuk menampilkan message
{
    $ci = get_instance();
    if ($tipe) {
        $ci->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Selamat!</strong> ' . $message . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    </div>');
    } else {
        $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Maaf!</strong> ' . $message . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    </div>');
    }
}

function output_json($data) //ini untuk mengubah data menjadi json
{
    $ci = get_instance();
    $ci->output->set_content_type('application/json')->set_output(json_encode($data));
}
