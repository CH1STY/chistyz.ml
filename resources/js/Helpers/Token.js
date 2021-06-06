class Token{

    isValid(token){
       
        const payload= this.payload(token);
        if(payload){
            if(payload.iss == "http://localhost:8000/api/auth/login" ||  payload.iss=="http://localhost:8000/api/auth/signup" || payload.iss=='https://www.chistyz.ml/api/auth/login' || payload.iss=='https://www.chistyz.ml/api/auth/signup' ){

                return true;

            }
            else
            {
                return false;
            }
        }
        return false;
    }

    payload(token)
    {
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload)
    {
        
        try{

            return JSON.parse(atob(payload));
        }
        catch(err)
        {
            localStorage.clear();
            window.location.reload();
            return false;
        }
       
       
       
    }

}

export default Token = new Token()