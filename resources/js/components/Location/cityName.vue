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
                        this.cityname= res.data.postal+" , "+res.data.city + " , "+ res.data.region +" , "+res.data.country;
                        if(res.data.city == undefined)
                        {
                            this.cityname = ""
                        }
                    })
                    .catch(err=>this.cityname="Please Turn off Adblocker")

                });
            }
        }

        
    }
</script>