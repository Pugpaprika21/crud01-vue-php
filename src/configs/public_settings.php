<?php

$t = time();

return [
    'JS' => [
        'AJAX' => "https://code.jquery.com/jquery-3.6.4.min.js?t={$t}", 
        'FETCH_' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/3.6.2/fetch.js" integrity="sha512-20FZL4lG1jTZXPeMkblgj4b/fsXASK5aW87Tm7Z5QK9QmmYleVGM0NlS9swfb6XT8yrFTAWkq3QfnMe7MKIX8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>',
        'FETCH' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/3.6.2/fetch.min.js" integrity="sha512-1Gn7//DzfuF67BGkg97Oc6jPN6hqxuZXnaTpC9P5uw8C6W4yUNj5hoS/APga4g1nO2X6USBb/rXtGzADdaVDeA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>',
        'AXIOS' => "https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js?t={$t}",
        'AXIOS_UNPKG' => '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>',
        'SWL_ALERT' => "https://cdn.jsdelivr.net/npm/sweetalert2@11?t={$t}",
        'SWL_ALERT_ALL' => '<script src="sweetalert2.all.min.js"></script>',
        'BOOTSTRAP' => "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js?={$t}",
        'VUE' => "https://unpkg.com/vue@3/dist/vue.global.js?t={$t}"
    ]
];

