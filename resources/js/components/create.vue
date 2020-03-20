<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th></th>
                    </tr>

                    <tr v-for="team in teams">
                        <td>{{team.id}}</td>
                        <td>{{team.name}}</td>
                        <td><input v-model="team.selected" type="checkbox"></td>
                    </tr>

                    <tr>
                        <td>New team</td>
                        <td><input type="text" placeholder="input team name" v-model="newTeamName"></td>
                        <td><button class="btn btn-success" v-on:click="newTeam">Add</button></td>
                    </tr>
                </table>

                <button class="btn btn-success" v-on:click="newTournament">Create Tournamnet</button>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                teams: [],
                newTeamName: ''
            };
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch : function () {
                axios.get('/team/list').then((res) => {
                    this.teams = res.data;
                })
            },
            newTeam: function () {
                axios.post('/team/create', {name : this.newTeamName}).then((res) => {
                    this.teams.push(res.data);
                })
            },
            newTournament: function () {
                axios.post('/tournament/create', {
                    teams: this.teams.filter(team => team.selected).map(team => team.id)
                })
                    .then((res) => {
                        location.href = '/tournament/' + res.data.id;
                    })
            }
        }
    }
</script>
