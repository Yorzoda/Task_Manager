    /*jshint esversion: 6 */

    /**
     * First we will load all of this project's JavaScript dependencies which
     * includes Vue and other libraries. It is a great starting point when
     * building robust, powerful web applications using Vue and Laravel.
     */

    require('./bootstrap');

    window.Vue = require('vue');

    /**
     * The following block of code may be used to automatically register your
     * Vue components. It will recursively scan this directory for the Vue
     * components and automatically register them with their "basename".
     *
     * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
     */

    // const files = require.context('./', true, /\.vue$/i);
    // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

    Vue.component('example-component', require('./components/ExampleComponent.vue').default);

    /**
     * Next, we will create a fresh Vue application instance and attach it to
     * the page. Then, you may begin adding components to this application
     * or customize the JavaScript scaffolding to fit your unique needs.
     */


    const app = new Vue({
        el: '#app',
    });


    $('#userAdd').on("input", function () {
        if (this.value.length >= 1) {
            $.ajax({
                url: `/find/${$('#userAdd').val()}`,
                type: 'get',
                success: function (data) {
                    showResults(data);
                }
            });
        } else if (this.value.length == 0) {
            $('.result').html('');
        }
    });

    function showResults(data) {
        $('.result').html('');
        if (data.length === 0) {
            $('.result').append('<span style="color: #ff0000">Совпадений нет</span>');
        } else {
            for (var x = 0; x < data.length; x++) {
                $('.result').append(`<div class="resultItem btn btn-light  " 
                style="
                border:1px solid #000;
                margin-top:20px;
                margin:10px;
                
                " data-id="${data[x].id}">${data[x].name} <i class="fa fa-plus"></div>`);
            }
        }
    }

    $(document).on('click', '.result', function () {
        $('.resultItem').remove();
    });

    $(document).on('click', '.removeItem', function () {
        $(this).parent().remove();
    });
    
    $(document).on('click', '.resultItem', function () {
        let id = $(this).attr("data-id");
        let isExist = false;
        $(".item").each((index, item) => {
            if ($(item).attr('data-id') === id) {
                isExist = true;
                return;
            }
        });
        if (isExist) {
            $('.result').append('<span style="color: #ff0000">Пользователь уже добавлен</span>');
        } else {
            $('.resultAdd').append(`
            <div class="item btn btn-primary" data-id="${$(this).attr('data-id')}">
            ${$(this).text()}
            <i class="fa fa-trash removeItem"></i>
            </div>`);

            if ($('#userAdd').val() != 0) {
                $('#userAdd').val('');
            }
        }


    });

    function saveTask() {
        let users = [];
        $('.item').each((ind, val) => {
            users.push($(val).attr('data-id'));
        });
        $.ajax({
            url: '/tasks/store',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                users,
                title: $('#taskTitle').val(),
                description: $('#taskDescription').val(),
                status: $('#taskStatus').val()
            },
            success: function (result) {
                result = JSON.parse(result);
                if (result.id) {
                    window.location.href = "/tasks/" + result.id;
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
