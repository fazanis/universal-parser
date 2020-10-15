<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="overlay" v-show="load">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>{{allParsers}}</h3>

                        <p>Всего парсеров</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <router-link to="/parsers" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></router-link>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="overlay" v-show="load">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>{{countactiv}}</h3>

                        <p>Активных парсеров</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <router-link to="/parsers" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></router-link>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="overlay" v-show="load">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>44</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="overlay" v-show="load">
                        <i class="fas fa-3x fa-sync-alt"></i>
                    </div>
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                load:false,
                allParsers:'',
                countactiv:''
            }
        },
        mounted() {
            this.getParser();
        },
        methods:{
            getParser(){
                this.load = true;
                this.$Progress.start();
               axios.get('api/countparser').then((response)=>{
                    this.allParsers = response.data.countall;
                    this.countactiv = response.data.countactiv;
                   this.load = false;
                   this.$Progress.finish();
               });
            }
        }
    }
</script>
