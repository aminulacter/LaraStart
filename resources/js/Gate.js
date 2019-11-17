export default  class  {
   
    constructor(user) {

        this.user = {...user};
        
    }

    isAdmin() {
           
        return this.user.type === "admin" || this.user.type === "author";
    }

    isUser() {
        return this.user.type === "user";
    }
}

