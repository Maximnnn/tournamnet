<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button class="btn" v-on:click="togglePlays">Finished games</button>
                <div class="row d-none">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td>Teams</td>
                                <td>Score</td>
                                <td>Type</td>
                            </tr>
                            <tr v-for="play in plays.filter(play => play.finished)">
                                <td>{{teamsLabel(play)}}</td>
                                <td>{{play.score_left}} - {{play.score_right}}</td>
                                <td>{{typeLabel(play.play_type_id)}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <button class="btn" v-on:click="togglePlays">Not Finished Games</button>
                <div class="row d-none">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td>Teams</td>
                                <td>Score</td>
                            </tr>
                            <tr v-for="(play, index) in plays" v-if="!play.finished">
                                <td>{{teamsLabel(play)}}</td>
                                <td>
                                    <input type="text" v-model="play.score_left" @keydown="playChanged(index)">
                                    <input type="text" v-model="play.score_right" @keydown="playChanged(index)">
                                </td>
                                <td><button class="btn btn-success" @click="updatePlay(index)" v-if="play.changed === true">Save</button></td>
                                <td><button class="btn btn-success" @click="finishPlay(index)">Finish</button></td>
                            </tr>
                        </table>
                    </div>

                </div>
                <br>
                <button class="btn" v-on:click="generatePlays">Generate Plays</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['tournament', 'types'],
        data: function() {
            return {
                plays: [],
                teams: []
            };
        },
        mounted() {
            this.plays = this.tournament.plays;
            this.teams = this.tournament.teams;
        },
        methods: {
            togglePlays: function(e) {
                e.target.nextElementSibling.classList.toggle('d-none');
            },
            teamsLabel: function(play) {
                return this.teamLabel(play.team_left) + ' - ' + this.teamLabel(play.team_right);
            },
            teamLabel: function(teamId) {
                let name = '';
                this.tournament.teams.some((team) => {
                    if (team.id === teamId) {
                        name = team.name;
                        return true;
                    }
                    return false;
                });
                return name;
            },
            updatePlay: function (index) {
                this.plays[index].changed = false;
                axios.post('/play/update', this.plays[index]).catch(() => {
                    this.plays[index].changed = true;
                });
            },
            playChanged: function (index) {
                this.plays[index].changed = true;
            },
            finishPlay: function (index) {
                this.plays[index].finished = true;
                axios.post('/play/end/' + this.plays[index].id).catch(() => {
                    this.plays[index].finished = false;
                });
            },
            typeLabel: function(id) {
                let label = '';
                this.types.some((type) => {
                    return (type.id === id) ? label = type.name : false;
                }) ;
                return label + ' play';
            },
            generatePlays: function() {
                axios.post('/tournament/generatePlays/' + this.tournament.id).then((res) => {
                    this.plays = this.plays.concat(res.data);
                })
            }
        },
    }
</script>
