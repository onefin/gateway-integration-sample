
// Merchant key provide by OneFin

const privateKey = 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCd6eBTS8W52RbN9ToUZ5ltPoKa0ZAEuKhnh1EVDWEDugHzQUNOtqLOJEFyAnIkPceSLWzepRzgl3+ZN82I6sRL5KkN930MJsDOa4eFUWBLjcOsioZtNMGjf9xnZ85gYrULoFbGF9wfyH8uPnf28eZCfkn0ZyqDglFQpZiKDgv5UmNFAAOAMORFnUaozn8U11UV/wbEiIbh4GFQpdLz/pKm0tHxx6FM3oA5BxDrfYRB5zSthr7VeYAFDUdj8WrB6C1Jq1crrznX6LXVxHXG5wKYRaFeqJM2bNywRT+X05DBbHr5QXqnllVCeBUkFcuEztn6fKEWsu3gj2Zrg54mI9ofAgMBAAECggEAD3szQ9dE3jB7PNvSwtdZQk2DjlwHK39S+ztX5qF2JmBg+pEmYRwkn+MMC3pT6FuqKhmL99PmHdqcZtACtW6Wqf4T2MuvlbZi5pnCIn7U2vNeAJdgEGrApR/O4tBZejeTGj2w5CDIstD8LvNu3WXfthsdcvl+QIBRKn/hkX9JCzsxYEC6L12GplsWKubfxRhCN6+dRffbjbkpLU9I4cLKbRRy5nXBzIYHGA6lgVNUW+qmeCTgnJgmcByQZMxgN3n5e4q9xikVfLnhIhE2oKesn8LIB3y5VC/vdALKwrd75e056F45j5uyXzxzbDYnI+81u08c416gpGFjBh+cgTcaSQKBgQDy/wJkQHYu6VcZHCukJjPH1FG4ePwV9IGtfgqYKRSx3IAWhI7Uycoz4f8pjfZszjM6tu18rDZwDJxeUhWm1s3wAKGLroPgNuCrpfytpsYX7g7QsT0itCVL3M0PkSiGpbYHPESIZJdIjPShs0dxv4Z+8X4+mCiSu9xOPPXao0j5MwKBgQCmXUF1pdJ0f6BnkC4+bL7AxwrxE3FJTH1i9bDbheBZC7Z2nnuv7rSv3idHWfz2ut1b/RRY7vB2t/kJ2OPkmLyRIxj2hlbVl6dDcfK0zmVRfGCALl2pIZtLBVhICCwmim9qjOQBsCjY38ufZwVw/xU1cPQtPjYLfoHzRAEq9DpTZQKBgQDs47HfLgCJBy3D6vSYmC2Ot+vbHQcUGEN7cQ6++/2Sz1WHnj7oLriTD9UDG8SKmhLTQJYRHooLfh/Ky9cTyQEG4naah81EfftVGwJT/+vKVGfZB5CEDn71kBHRBUAu08m7EAP3u6jIL7IlGXOi7oYdpyvdtdSIB+Bj3YYIWXrAhQKBgBTRbKSVOI29fswW3cKQBxrGjZb3UODUQoiEqDoAOb/K2G1ljaLJYzDywsWJ/D6/yX1+YPJ0DAE/KlnSG0p61nXvB2uqCem2jYbCFpYLkeAtiUHhC3VjsDQmGhMBeszj2+dgdBPGAIaLEscCtEqckQHb/aI/u7GahhZz9xVx9G6FAoGBAMHp/xzT3fvL2DBISATVOViheeYV1wK0FjAF4GqrfB8Upo9nGqZhCBfsHqCJlh1ENOlNVK6yf9JEdxXFcD00FTO+QwOb8HBKne5WpviGRrrzbQlpUZX+yBkaD+vT8xvf/TXE5IpZZjqahVVbfyfCnLLQwCVm07iaXr2cf55Hej3o';
const publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAk1fKrfxZ/hyPGHA5x8j7dBshtoe586uVOjuDKREIyo6yrxvpHu/ycNSXQXzBr6JLK0GKtx4+ewCHZeMhvAdqmUnvTbUjubFI+lAAOVseH1EHLzdQh3w5nUZFYYaF3INclIYKzJNqnYVhqpRdY8amfnmjVW7oFuZghG//TYGfwTS015fmQI/nLb8O8DBL9CBONupTEasD+tJ41PN15JzZ7rGMSQvMFV3QYzo0CNCk6Ya1kVAVFPso3FEDEhVURuLkPBiu1TL6jpnB/z3F2XfVfJQS43blSyJjTZ7+nSUbCu/BOEgit32gscfCYW0bQdpuvaQOW0E009+nQTd04ET8OwIDAQAB'
const merchantCode = '00022';
const uniqid = require('uniqid');
const axios = require('axios');
const { generateSignature, verifySignature } = require('../utils/signature');

const generatePayment = async (req,res) => {
    const id = uniqid();
    const message = {
        "merchantCode": merchantCode,
        "currency": "VND",
        "amount": 500000,
        "trxRefNo": id,
        "backendURL": "https://sit-pgw.onefin.vn/public/mweb/mockReturnAPI",
        "responsePageURL": "https://example.com",
        "mobileNo": "090000000",
        "transactionMethod": "",
        "actionMethod": "0",
        "email": "customer_email@onefin.vn"
    }

    const sendMessage = JSON.stringify(message);

    const body = {
        messages: sendMessage,
        signature: generateSignature(sendMessage, privateKey)
    }
    try {
        const response = await axios({
            method: 'POST',
            url: 'https://sit-pgw.onefin.vn/public/mweb/generatePayment',
            headers: {
                'Content-Type': 'application/json'
            },
            timeout: 60000,
            data: body
        });
        const isSignatureValid = verifySignature( response.data.messages,  response.data.signature, publicKey);
        if(isSignatureValid){
            res.json(response.data);
        }
    } catch (error){
        console.error(error);
        res.status('500').send('Internal Server Error');
    }
}

const checkPaymentStatus = async (req,res) => {
    const id = req.body.id;
    const message = {
        "merchantCode" :merchantCode,
        "trxRefNo": id,
    }

    const sendMessage = JSON.stringify(message);

    const body = {
        messages: sendMessage,
        signature: generateSignature(sendMessage, privateKey)
    }
    try {
        const response = await axios({
            method: 'POST',
            url: 'https://sit-pgw.onefin.vn/public/mweb/checkPayment ',
            headers: {
                'Content-Type': 'application/json'
            },
            timeout: 60000,
            data: body
        });
        const isSignatureValid = verifySignature( response.data.messages,  response.data.signature, publicKey);
        if(isSignatureValid){
            res.json(response.data);
        }
    } catch (error){
        console.error(error);
        res.status('500').send('Internal Server Error');
    }
}

const queryToken = async (req,res) => {
    const id = req.body.memberId;
    const message = {
        "merchantCode": merchantCode,
        "memberId": id,
    }

    const sendMessage = JSON.stringify(message);

    const body = {
        messages: sendMessage,
        signature: generateSignature(sendMessage, privateKey)
    }
    try {
        const response = await axios({
            method: 'POST',
            url: 'https://sit-pgw.onefin.vn/public/mweb/checkToken ',
            headers: {
                'Content-Type': 'application/json'
            },
            timeout: 60000,
            data: body
        });
        const isSignatureValid = verifySignature( response.data.messages,  response.data.signature, publicKey);
        if(isSignatureValid){
            res.json(response.data);
        }
    } catch (error){
        console.error(error.response);
        res.status('500').send('Internal Server Error');
    }
}

const unbindCard = async (req,res) => {
    const id = req.body.paymentToken;
    const message = {
        "merchantCode": merchantCode,
        "paymentToken": id,
    }

    const sendMessage = JSON.stringify(message);

    const body = {
        messages: sendMessage,
        signature: generateSignature(sendMessage, privateKey)
    }
    try {
        const response = await axios({
            method: 'POST',
            url: 'https://sit-pgw.onefin.vn/public/mweb/unbindCard ',
            headers: {
                'Content-Type': 'application/json'
            },
            timeout: 60000,
            data: body
        });
        const isSignatureValid = verifySignature( response.data.messages,  response.data.signature, publicKey);
        if(isSignatureValid){
            res.json(response.data);
        }
    } catch (error){
        console.error(error.response);
        res.status('500').send('Internal Server Error');
    }
}

const callback = async (req,res) => {
    const isSignatureValid = verifySignature( req.body.messages,  req.body.signature, publicKey); 
    if(isSignatureValid){
        //do something
    }
}


module.exports = {
    generatePayment,
    checkPaymentStatus,
    queryToken,
    unbindCard,
    callback
}