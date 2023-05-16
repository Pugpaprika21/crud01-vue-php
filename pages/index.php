<?php
require __DIR__ . '../../src/include/include.php';

$url = "../../crud01-vue-php/process/";

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- main-css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css?T=<?= CREATE_TIME_AT ?>" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css?T=<?= CREATE_TIME_AT ?>">
    <!-- main-css -->

    <!-- main-js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js?T=<?= CREATE_TIME_AT ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js?T=<?= CREATE_TIME_AT ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11?T=<?= CREATE_TIME_AT ?>"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js?T=<?= CREATE_TIME_AT ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js?T=<?= CREATE_TIME_AT ?>"></script>
    <!-- main-js -->

    <!-- data table -->
    <script src="https://code.jquery.com/jquery-3.5.1.js?T=<?= CREATE_TIME_AT ?>"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js?T=<?= CREATE_TIME_AT ?>"></script>

    <style>
        .main-card {
            margin-top: 40px;
        }

        .my-btn {
            color: white;
            border-color: #5E00A7;
            background-color: #5E00A7;
            border: 2px solid transparent;
            transition: all 0.5s ease;
        }

        .my-btn:hover {
            border-color: #8A35CD;
            background-color: #8A35CD;
        }

        .tb-thead {
            color: white;
            background-color: #5E00A7;
            text-align: center;
            font-size: 16px;
        }

        .dataTables_length {
            margin: 10px 0px 10px 0px;
        }

        .dataTables_info {
            margin: 10px 0px 10px 0px;
        }

        .dataTables_paginate {
            margin: 10px 0px 10px 0px;
        }
    </style>

</head>

<body style="background-color: #ECF0F1;">
    <!-- nav -->
    <nav class="navbar bg-body-tertiary shadow bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../upload/image/bootstrap-logo-shadow.png" alt="Logo" width="32" height="30" class="d-inline-block align-text-top">
                Bootstrap
            </a>
        </div>
    </nav>
    <!-- nav -->
    <div class="container-fluid">

        <!--  -->
        <div class="card main-card shadow-sm" id="app-crud01">
            <div class="card-header">
                {{ message }}
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-6 col-md-4">
                        <form @submit.prevent="formAddUser">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" v-model="username" placeholder="Username">
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control" v-model="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm mt-3 w-100 my-btn">Save</button>
                        </form>
                    </div>
                    <div class="col-6 col-md-8">
                        <table class="table table-bordered" id="crud-vue01" class="display" style="width:100%">
                            <thead class="tb-thead">
                                <tr>
                                    <th>#</th>
                                    <th>username</th>
                                    <th>password</th>
                                    <th>create_at</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in userRows" :key="user.user_id">
                                    <td>{{ index + 1 }}</td>
                                    <td v-if="">{{ user.user_name }}</td>
                                    <td>{{ user.user_pass }}</td>
                                    <td>{{ user.create_date_at }} {{ user.create_time_at }}</td>
                                    <td><a class="btn btn-primary btn-sm" @click="getUserById(user.user_id)" role="button">Edit</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!--  -->

    </div>
    <!--  -->
</body>

</html>

<script>
    const {
        createApp
    } = Vue

    createApp({
        data() {
            return {
                action: [],
                message: "CRUD",
                username: "",
                password: "",

                userRows: []
            }
        },
        methods: {
            formAddUser() {
                const username = this.username;
                const password = this.password;

                axios.post("<?= url_where("{$url}action.php") ?>", {
                    action_: 'insert',
                    username: username,
                    password: password
                }).then(res => {
                    this.fetchAll();
                    this.username = '';
                    this.password = '';

                }).catch(err => {
                    console.error(err);
                });
            },
            async fetchAll() {
                const users = await axios.get("<?= url_where("{$url}fetchUser.php", array('action_' => 'fetchAll')) ?>");
                this.userRows = users.data;

                console.log(`users`, this.userRows.length);
            },
            getUserById(userId) {
                console.log(`Get User with ID: ${userId}`);
            }
        },
        mounted() {
            this.fetchAll();
        },
    }).mount('#app-crud01');

    document.addEventListener("DOMContentLoaded", () => {
        $('#crud-vue01').DataTable();
    });
</script>