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
                this.level_enabled = !this.level_enabled;
            },
            checkRequire(event){
                if (event.target.value != '') {
                    this.username = true;
                }
            },

        },
    }
</script>
