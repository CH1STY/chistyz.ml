<template>
   <div>
            <div class="card mx-auto" style="width: 80%;">
            <div class="card-body">
                <h1 class="text-center">Registration Form</h1>
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input name="name" type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Enter email"/>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input name="email" type="email" class="form-control"  aria-describedby="emailHelp" placeholder="Enter email"/>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input name="password" type="password" class="form-control"  placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input name="password_confirmation " type="password" class="form-control" placeholder="Password"/>
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
                <router-link class="text-center text-info" to="/login">Already A User? Login</router-link>
            </div>
            </div>

    </div>
</template>

<script>
</script>

<style scoped>
</style>