<template>
    <span>{{cityname}}</span>
</template>

<script>
    export default{
        data()
        {
            return{
                cityname: "",
            }
        },
        created(){
            this.getCity_Country();
        },
        methods:{
            getCity_Country()
            {
                let ip= "";
                axios.get('/api/client-ip')
                .then(res=>
                {
                    ip=res.data
                    axios({
                        method: 'GET',
                        url:  `https://ipapi.co/${ip}/json/`,
                    })
                    .then(res=>{
                        this.cityname= res.city + " , "+ res.country_name;
                    })

                });
            }
        }

        
    }
</script>