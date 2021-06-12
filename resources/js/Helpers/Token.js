class Token{

    isValid(token){
       
        const payload= this.payload(token);
        if(payload){

            

            if(payload.iss == "http://localhost:8000/api/auth/login" ||  payload.iss=="http://localhost:8000/api/auth/signup" || payload.iss=='https://www.chistyz.ml/api/auth/login' || payload.iss=='https://www.chistyz.ml/api/auth/signup' ){

                
                if((Date.now()/1000) > payload.exp){
                    localStorage.clear();
                    window.location.reload();
                    return false;
                }
                else
                { 
                    return true;
                }
                


            }
            else
            {
                localStorage.clear();
                window.location.reload();
                return false;
            }

          
        }
        return false;
    }

    payload(token)
    {
        const payloadIntro = token.split('.')[0];
        const payload = token.split('.')[1];
        return this.decode(payload,payloadIntro);
    }

    decode(payload,payloadIntro)
    {
        
        try{
            
            JSON.parse(atob(payloadIntro));
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