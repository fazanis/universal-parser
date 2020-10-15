<template>
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Парсеры</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link to="/dashboard">Главная</router-link></li>
                            <li class="breadcrumb-item active">Парсеры</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Список парсеров</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-success" data-toggle="modal" @click.prevent="newParser()">
                                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                            </button>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>url</th>
                                <th>Статус</th>
                                <th>Дата добавления</th>
                                <th>Дата обновления</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="parser in parsers.data">
                                <td>{{parser.name}}</td>
                                <td>{{parser.url}}</td>
                                <td>{{parser.status}}</td>
                                <td>{{parser.created_at | myDate}}</td>
                                <td>{{parser.updated_at | myDate}}</td>
                                <td>
                                    <a href="" @click.prevent="editParser(parser)">
                                        <i class="fa fa-align-center" aria-hidden="true"></i>

                                    </a> /
                                    <a href="" @click.prevent="deleteParser(parser.id)">
                                        <i class="fa fa-trash red" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <pagination :data="parsers" @pagination-change-page="loadParser"></pagination>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!edit" id="exampleModalLabel">Добавление</h5>
                        <h5 class="modal-title" v-else id="exampleModalLabel">Редактирование</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="edit ? addUpdate() : addNew()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Название</label>
                            <input v-model="form.name" type="text" name="name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input v-model="form.url" type="text" name="url"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('url') }">
                            <has-error :form="form" field="url"></has-error>
                        </div>
                        <div class="form-group">
                            <label>title</label>
                            <input v-model="form.title" type="text" name="url"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>
                        <div class="form-group">
                            <label>text</label>
                            <input v-model="form.text" type="text" name="text"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('text') }">
                            <has-error :form="form" field="text"></has-error>
                        </div>
                        <div class="form-group">
                            <label>фото</label>
                            <input v-model="form.photo" type="text" name="photo"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('photo') }">
                            <has-error :form="form" field="photo"></has-error>
                        </div>
                        <div class="form-group">
                            <label>status</label>
                            <input v-model="form.status" type="checkbox" name="status"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                            <has-error :form="form" field="status"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                form: new Form({
                    id:'',
                    name:'',
                    url:'',
                    title:'',
                    text:'',
                    photo:'',
                    status:false,
                }),
                parsers:[],
                edit:true,
            }
        },
        created() {
            this.loadParser();
            Fire.$on('AfterCreate',()=>{
                this.loadParser();
            });
        },
        methods:{
            newParser(){
                this.edit = false;
                this.form.reset();
                $('#openModal').modal('show');
            },
            addNew(){
                this.form.post('api/parser').then(()=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'Парсер сохранен'
                    })
                    Fire.$emit('AfterCreate');
                    $('#openModal').modal('hide');
                });
            },
            addUpdate(){
                this.form.put('api/parser/'+this.form.id).then(()=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'Парсер обновлен'
                    })
                    Fire.$emit('AfterCreate');
                    $('#openModal').modal('hide');
                });
            },
            editParser(parser){
                this.edit = true;
                this.form.reset();
                $('#openModal').modal('show');
                this.form.fill(parser);
            },
            loadParser(page = 1){
                this.$Progress.start();
                axios.get('api/parser?page=' + page).then((response)=>{
                    this.parsers = response.data;
                    this.$Progress.finish();
                });
            },
            deleteParser(id){
                Swal.fire({
                    title: 'Вы уверены?',
                    text: "Запись будет удалена без возвратно!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да, удалить',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.delete('api/parser/'+id).then(()=>{
                            Fire.$emit('AfterCreate');
                        });
                        Swal.fire(
                            'Удалено!',
                            'Запись успешно удалена.',
                            'success'
                        )
                    }
                })

            }
        }
    }
</script>
