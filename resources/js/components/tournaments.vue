<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a v-bind:href="link(tournament)" v-for="tournament in tournaments">Tournament {{tournament.id}} ({{tournament.created_at}})</a>
            </div>
            <div class="col-md-8 m-3">
                <a href="/tournament/create">Create</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                'tournaments': []
            };
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch : function () {
                axios.get('/tournaments/list').then((res) => {
                    this.tournaments = res.data.data;
                })
            },
            link : function(tournament) {
                return '/tournament/' + tournament.id;
            }
        }
    }
</script>
