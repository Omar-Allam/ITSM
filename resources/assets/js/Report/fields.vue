<template>
    <div class="fields-container">
        <div class="original-fields form-group select-box">
            <select id="originalFields" class="form-control" v-model="toRight" size="10" multiple>
                <option v-for="(text, index) in notSelectedFields" :value="index" v-text="text"></option>
            </select>
        </div>
        <div class="buttons">
            <button class="btn btn-default btn-sm to-right" type="button" @click="moveToRight" :disabled="! toRight.length"><i class="fa fa-chevron-right"></i></button>
            <button class="btn btn-default btn-sm to-left"  @click="moveToLeft" :disabled="! toLeft.length"><i class="fa fa-chevron-left"></i></button>
        </div>
        <div class="selected-fields form-group select-box">
            <select name="fields" id="selectedFields" class="form-control" v-model="toLeft" size="10" multiple>
                <option v-for="(text, index) in selectedFields" :value="index" v-text="text"></option>
            </select>
            <input type="hidden" name="fields" v-model="parsedSelection">
        </div>
    </div>
</template>

<style>
    .fields-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .select-box {
        flex: 1;
        margin-bottom: 0;
    }

    .buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        margin: 0 10px;
    }

    .buttons .to-right {
        margin-bottom: 10px;
    }
</style>

<script>
export default {
    props: ['original', 'initial'],

    data() {
        return {
            selected: this.initial,
            allFields: this.original,
            toRight: [],
            toLeft: []
        };
    },

    methods: {
        moveToRight() {
            this.toRight.forEach(fields => this.selected.push(fields));
        },

        moveToLeft() {
            this.selected = this.selected.filter(field => ! this.toLeft.includes(field));
        }
    },

    computed: {
        notSelectedFields() {
            const notSelectedFields = {};

            for (let k in this.allFields) {
                if (!this.selected.includes(k)) {
                    notSelectedFields[k] = this.allFields[k];
                }
            }
            
            return notSelectedFields;
        },

        selectedFields() {
            const selectedFields = {};
            this.selected.forEach(field => {
                selectedFields[field] = this.allFields[field];
            });

            return selectedFields;
        },

        parsedSelection() {
            return this.selected.join(',');
        }
    }
}

</script>
