function validate()
{
    let returnval=true;
    let name,Lastname,email,pincode;
    name=form1.t1.value;
    email=form1.emailid.value;
    phone=form1.contact.value;
    pincode=form1.pin.value;
    let alphabet=/^[A-Za-z]+$/;
    if(!alphabet.test(name))
    {
        alert("Name cannot contain integer value");
        returnval=false;
    }

    if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
    {
        alert("Invalid email");
        returnval=false;
    }
    if(isNaN(phone))
    {
        alert("Phone number should only contain integer value");
        returnval=false;
    }
    if(phone.length!=10)
    {
        alert("Phone number should be equal to 10")
        returnval=false;
    }
   if(isNaN(pincode))
   {
        alert("Pincode should only contain integer values")
   }
    return returnval;
}

