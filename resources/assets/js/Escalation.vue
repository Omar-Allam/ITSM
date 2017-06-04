<template>
    <div>
        <section class="panel panel-primary panel-sm">
            <div class="panel-heading">

                <h4 class="panel-title">
                    <input type="checkbox" name="enableLeveL[]" id="enableLeveLOne"
                           @click="enableEnabled()">
                    Enable Escalation Level {{level}}</h4>
            </div>
            <table class="table table-striped" v-show="level_enabled">
                <thead>
                <tr>
                    <td><label for="level[]"> Escalate to</label></td>
                    <td><input type="text" class="form-control" name="level[]"
                                v-on:blur="checkRequire($event)" :disabled="!level_enabled">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#techModal" data-close="chooseTech">Choose
                        </button>
                    </td>
                    <td>
                        <input type="checkbox" :name="assign+level" :disabled="!level_enabled"><strong style="margin-right: 10px">Assign</strong>
                    </td>

                </tr>
                <tr>
                    <td></td>
                    <td>Days</td>
                    <td>Hours</td>
                    <td>Minutes</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-md-3">
                        <input type="radio" value="-1" class="" :name="option+level" :disabled="!level_enabled">Escalate Before
                        <input type="radio" :name="option+level" value="1" :disabled="!level_enabled">Escalate After
                    </td>

                    <td class="col-md-3">
                        <input type="number"  class="form-control input-sm" name="level_days[]" :disabled="!level_enabled"></td>
                    <td class="col-md-3">
                        <select class="form-control input-sm" name="level_hours[]" :disabled="!level_enabled">
                            <option v-for="(item,index) in hours" :disabled="level_enabled">{{index}}</option>
                        </select>
                    </td>
                    <td class="col-md-3">
                        <select class="form-control input-sm" name="level_minutes[]" :disabled="!level_enabled">
                            <option v-for="(item,index) in minutes">{{index}}</option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>

    </div>
</template>

<script>
    export default {
        props: ['level'],
        data() {
            return {
                minutes: 60,
                hours: 24,
                level_enabled: false,
                option: 'option',
                assign: 'assign',
                username: false,
            }
        },
        methods: {
            enableEnabled(){
                this.level_enabled =!this.level_enabled;
            },
            checkRequire(event){
                if (event.target.value != '') {
                    this.username=true;
                }
            }
        }
    }
</script>
