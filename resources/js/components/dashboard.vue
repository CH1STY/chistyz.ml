<template>
    <div>
        <navbar/>
        <h2 class="text-center text-uppercase h3">Welcome {{username}}</h2>
        <div class="row">
            <div class="col-md-7 btmMar" >
                <div class="card bg-dark">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                                <div class="card-header h3 text-center text-white text-uppercase">
                                    ADD TO DO
                                </div>
                                    <div class="form-group">
                                        <label >Title</label>
                                        <input type="text"  class="form-control" v-model="form.title" name="title"   placeholder="Enter Title"/>
                                        <small v-if="errors.title" class="form-text text-danger" >{{errors.title[0]}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label >Details</label>
                                        <input type="text"  class="form-control" v-model="form.details"  name="details"   placeholder="Enter Details"/>
                                        <small v-if="errors.details" class="form-text text-danger"  >{{errors.details[0]}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label >Date and Time</label>
                                        <input type="datetime-local" v-model="form.date"  class="form-control"  name="date"   placeholder="Enter Date and Time"/>
                                        <small v-if="errors.date" class="form-text text-danger">{{errors.date[0]}}</small>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>              
            </div>
            <div class="col-md-5 overflow-auto btmMar border"  style=" max-height:30rem;">
                <div class="card-header h4 text-center text-info text-uppercase">
                    TO-DO List
                </div>
                <div v-for="todo in todos" :key="todo.id" class="card bg-dark ">
                    <div class="card-body greenBorder">
                        <h6>{{todo.header}}</h6>
                        <p>{{todo.details}}</p>
                        <p>{{todo.todo_date}}</p>
                    </div>
                </div>                            
            </div>
        </div>
    </div>
</template>

<script>
import navbar from './navbar.vue';

export default {
  components: { navbar },
    beforeCreate()
    {
        if(!User.loggedIn())
        {
            this.$router.push({name:'login'});
        }
    },
    created(){
        this.getTodo();
    },
    data(){
        return{
            form:{
                title: null,
                details:null,
                date:null,
            },
            todos : {},
            username: localStorage.getItem('user'),
            errors:{},
        }
    },
    methods:{

        getTodo()
        {
            axios({
                method: 'get',
                url: '/api/user/getTodo',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')} `
                }
            })
            .then(res=>this.todos=res.data)
        },
        submit()
        {
            axios({
                    method: 'post',
                    url: '/api/user/addTodo',
                    data: this.form,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
            })
            .then(res=>{
                if(res.data=='Success')
                {
                    Toast.fire({
                        icon: 'success',
                        title: 'TODO ADDED',
                    })
                    this.form.title = null;                   
                    this.form.date = null;                   
                    this.form.details = null; 
                    this.errors = {};
                    this.getTodo();                  
                }
                else
                {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid',
                    })
                }
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
                Toast.fire({
                    icon: 'warning',
                    title: 'Invalid',
                })
            })           

        }
    }
}
</script>


<style scoped>
.row{
    margin: auto;
}
.btmMar{
    margin-bottom: 20px;
}
.border{
    box-shadow: 
    0 0 1px #fff,
    0 0 2px #fff,
    0 0 3px #fff,
    0 0 4px #0fa,
    0 0 5px #0fa,
    0 0 6px #0fa,
    0 0 7px #0fa,
    0 0 8px #0fa;
}

.greenBorder{
    margin-bottom:5px;
    border: 2px solid rgb(9, 248, 128);
}
</style>
