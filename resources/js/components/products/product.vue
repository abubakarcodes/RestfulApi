<script>
export default{
    data:function(){
       return {
            product:[],
        errors:[],
       }
    },

    methods:{
        getProduct(){
            axios.get()
            .then(res => {
                console.log(res)
            })
            .catch(err => {
                console.error(err);
            })
        }
    }
}

</script>
