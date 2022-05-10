const privateKey = 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQChfcE39K3OPXj9zqUS0MJM274ClG0bn0eDC6gqMPuPZ8gaLwOJzsgP/vYKGmyNn1kTESw+z+rytTcAd/vUFfWPb45VkIMbR1L8C8KbYt4jWMGsuXKJIFUWRaEiTtMBVFGR0E1p2rF+Nle9y/mwIMrisjhO6MeonAzGSlIY5ysn0vIw7M0VwIQbebd6m5moAUJVUVZHFvnFJsB0Mh9xp7AURWEqElM/T8x9x4wTqYKrnclHxwgkCw+7SGI+Quw1nrYiWQ2rRk282vCrPeLExBN3/mMyGV4K5N6Pe2Yn6vK2c35pbpHLIEfEo+Y9RTt4Uxu3sbHyNzaEEjy/NyZtbLH7AgMBAAECggEAc6iWLpYtuKzsL5LFRRGAZv1mO4DEF+lelStPGFCWimGAvcf4F8WiIVqwKhI8tr1uVSqSbrYIhiVlLA/Cq2XCxiTWYs+qJmpRs7RUf2cyw0v5AdSbhDxE1DuwKNsdYjFabj0qhGqdflA7TPJ+dDc4N13+1/z9qfOBbq6h17YQgWb9rXzYD1F+pRIgp9ziOQBhB7kruDO41iOTeCCBMjO6pzDVjaI5EAl1695TNfnTNXFEpadVRq4WfJL6NADClYshwE7rIJzfYeZfx1b0r2lQWQSOOGPaVyD83UReKphkf2LGn86mRo2aO6LzmqPW3lpnrGXV9nRTzhiS4uhdpnvEYQKBgQDeIHgdjoQParnxI+dLDKF2O4VjCkBqMN0ikMPd/5KMv0JLmybVB95Mz4oKeow8ODTm4bhelgfoV6IyehGuxMfJV8XGyo+9fIzC7fJiTJfmC3c+r3nOgm09+gXK587JS12rFdPLqmk00zneitpX9NqY8xqUnZdmbv1yCs1DdLRHqwKBgQC6HidZRT5lzvoipO4Ich2wDhzkbuH54uERocNjIcKaA59+TrtJJYYSaTePkeX69t+Jyp1vaIYwLBdKNUMLZGJGrwdBn2DUiFV0yrPdw/2DaASTPXWN9PmnTUoKwpX6olK1s7tg0mZs01sDeOP5DQLgUAcMKM9LgyB9sgX5mf2u8QKBgHZU88hDIOUZpR7qUpAvlWBoCwIc9v3bNCLy3fVI7mheh1HBwKkiPPHMaix05no6MyyAOPjikinbbYPYdc0V9Zy0Tp89T9/RFyfNHR/yz8T0fLz/PDOgVdP7etSCMy4XITpAMYlBKjTDBgQhEnpi7YUnlRRw87PVEt2LFZiG9ndrAoGBAJ+3IK1K7rEPXTg9sMcupqtecQzW2rVGLT6kQrffUNA6K7SIe8/Zk6RZBoT9/w3OrSXh6hig6gaMz6+u5UnxaySdLuzxiHbaR/tht9inR/ZsXQC9zRN1Foirms6BDZN3mOK0yifcZmkdNw1TwM8Ii19TTbjxjHKQpGE5VEdODpUBAoGBALTr3Wo/b9Bp1cA5J1lQ66e5DcFFUM2eQX8JaKj2+zyzU1K7OCkJZ0DtLTiStdqL8XQuqxqk/c0X1UMAqhw90nXErYfdUXx4ddCcZGUEVsIoPCf8LhmDAA1jTJadx0f8IT15Qm6j2xlr/mtO9nBn8nwQ++2iHZv/V95kjDNTi1vW';
const publicKey = 'PublicKey Here'
const uniqid = require('uniqid');
const axios = require('axios');
const { generateSignature, verifySignature } = require('../utils/signature');

const generatePayment = async (req,res) => {
    const id = uniqid();
    const message = {
        "merchantCode": "00022",
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
        "merchantCode": "00022",
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

const callback = async (req,res) => {
    const isSignatureValid = verifySignature( req.body.messages,  req.body.signature, publicKey); 
    if(isSignatureValid){
        //do something
    }
}


module.exports = {
    generatePayment,
    checkPaymentStatus,
    callback
}