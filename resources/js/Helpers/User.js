import Token from './Token';
import AppStorage from './AppStorage';

class User{
    
    responseAfterLogin(res){
        const access_token = res.data.access_token;
        const username = res.data.name;
        
        if(Token.isValid(access_token))
        {
            AppStorage.store(access_token,username);
        }

    }

    hasToken()
    {
        const storeToken = localStorage.getItem('token');
        if(storeToken)
        {
            return Token.isValid(storeToken)? true: false;

        }
        return false;
    }

    loggedIn()
    {
        return this.hasToken();
    }

    logout()
    {
        localStorage.clear();
    }

    name()
    {
        if(this.loggedIn())
        {
            return localStorage.getItem('user');
        }
        return false;
    }
    id()
    {
        if(this.loggedIn())
        {
            const payload = Token.payload (localStorage.getItem('token'))
            return payload.sub;
        }
        return false;
    }

    async isAdmin()
    {
        
        const response = await axios({
                method: 'post',
                url: '/api/auth/me',
                data: this.form,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')} `
                }
            })
        

        const data = await response.data;
          
        if(data.name=='admin')
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }

}

export default User = new User();