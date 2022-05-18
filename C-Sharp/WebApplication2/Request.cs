using System;
using System.Collections.Generic;
using System.Text;
using System.Web;
using Newtonsoft.Json;
using Crypto;
using Newtonsoft.Json.Linq;

namespace WebApplication2
{
    public class Request
    {
        string privateKey = "<RSAKeyValue><Modulus>rtWB67UYXD+nzZx4BTuGB3h8ZLhA3pmWjDdRm7qcSQSfxF9QWkmFhS61FE7PC0P3YNa98VhNglcDwd2IxiwI0M/Vikp5/L0Yeu9VJ5dIhm3aP7uWZvS8AO45rn0XShirXKsdF2Gn+gbPqb51eEwvYMo73o+npaDoQK7G6x2zEKuejAXdWJIxegTBabMX1uqmg8YDiRWKmQ1CBliu3exRO/Y8mVC1fKkTbl1P5zotcfIUWXjfXmQcClteCi7DHzkH3conkDRyf85nDgnNbD0SQr6mLtc+6BTmeYcCOL408jf1Sxi8P9bQsHSB3nm+59Vjm53C9be6v0tPPTng0cZO9Q==</Modulus><Exponent>AQAB</Exponent><P>7904fTZk4i8rB7E0O6mKDPnVuHrhhSZYqB5VYkVgWrOkVTF+IKjvGyRsf4ZYqllF506nhl7qmAIBIujPuuw7xa2zv+gw6Ov4MuPsPHq1nELQK9HutTwZ/9aX1kf8giyR3viMXKh/FVXUfRntDpc6Zso51sviyM/AH/4TKpUnwDc=</P><Q>uphhr22Any2YwgMSjeQfEXz0lXsuSOuzNArFlxg7on5RK8FrGRXZMvY1gm9QGzRYEgBxPMgAkFKVOiwtunay8oVk9f7I7uNRYL+DXh36XjYVKw1BLlRNmh1sh3fkM1HHAcfc87RKoJa2pePHkorZ+uIHhu+VLHrXrVt2QhBTHDM=</Q><DP>4mNaMJvJJc29ADqZAQKoQE0BEWgxODmUDcDrd5/hLFpG7P2UfIDVhDmhic8kGku99W3AIcuuASBLMEap4VObqpyifatJll042ddTHVX32O8aiXFPqpB6PYSttFonEjm8x8SwvbdukpV6w0RYAKBtR5zwcDHo7v1d6RQlxNgYN4s=</DP><DQ>UGseJrIl7fSD0pHqbDa14R6edtIY95qFqFdAI0dxZC3Wo+n/U1dkPZ95HlcFCkR79H42T4DPJWRCJkkmCCfiJb2x7oc5aCOWTgEcB/MZlYLvipdy0RnKPDKUNKpKMof7IdxWcL3yL9XksAhEWfb3zTWfEtusyffDflZd2Eka2Js=</DQ><InverseQ>RMmaIoF0PwmLSrhcd9VUlbZ67AmsZkceKqlruDpOTB3zFo23BsKEIipYmwfsjimiIc61kEYRHGrb5BRaQrz8h9QnBv0a672NtS60/+yfrVXgMoJk84ROYznErudPcqbo3x9+157o3xV4G75L5LTaotOExJn7kehZeKX+zLURwW8=</InverseQ><D>lnr+kDoW9Y90huyeASLygYuaxbYxX2cixRz4COndipuISCUhrBSL78373bbXTgL58UfjxM8UJ5NtkHd1Ody82b2JNrZTuM2pPGazDJiRu+Lhbumu0n7jMonY6+6PFR+WnvRI3c8YHYOvSZK82QX54X0veqh6y3xrawEEBWpSrY0aohGezmO0UfmRO341A6h7yXD9H8ZYNntlib+LcR2yt8lZuihnwU6tiRw2Qi29FjGt9Ig0wSpB2bnu0RvWpLHxUCHaiqX+buBkd+SwypUuXHXGZfDOFfD7ZA7GMaG0Ca+Apr3GRm8JEobTOvNuZL9zQupr1m79LS00Jx3BYD6wIQ==</D></RSAKeyValue>";
        string publicKey = "<RSAKeyValue><Modulus>lkMDLDOzpooR2eR+SS1GCaxyrSItlKSHR4ec0YzsWceNtRJNt6zsstPsJC3jl4eRZJy52SspAZpWc787r2K9FoE/8x/bIFPCLDMf4bdCs/0KouzEAMqBzeQVPuqbyXa20I9YuqHu25GErVXSFkXUjWoGJCTLGCpTEdAC3t6BcVX7THlElmxyyEQ/bVBEQK6tX1irQZ4YCPdDFav9bLbJQ6ZPavC+Fn1eK78FmZzHivlW+e0xBBwpLF13skZpvpC8gvTqDNBum/iQhVmYahvwX5g9LzAQRLDAQfqYZYCn3imo03l2uU/4q/0r/8qPeNVHmEvZZ0T8gB2iV/a3GKPtSw==</Modulus><Exponent>AQAB</Exponent></RSAKeyValue>";
        string paymentURL = "https://sit-pgw.onefin.vn/public/mweb/generatePayment";
        SortedList<String, String> _requestFields = new SortedList<String, String>();
        String _rawResponse;
        SortedList<String, String> _responseFields = new SortedList<String, String>();
        String _secureSecret;


        public Request(string paymentURL)
        {
            this.paymentURL = paymentURL;
        }

        public void AddDigitalOrderField(String key, String value)
        {
            if (!String.IsNullOrEmpty(value))
            {
                _requestFields.Add(key, value);
            }
        }

        //_____________________________________________________________________________________________________
        // Three-Party order transaction processing

        public JObject Create3PartyQueryString()
        {
            string jsonText = JsonConvert.SerializeObject(_requestFields);
            string signature = RSA.SignRSASHA1(jsonText, privateKey);
            SortedList<String, String> body = new SortedList<String, String>();
            body.Add("messages", jsonText);
            body.Add("signature", signature);
            string jsonBody = JsonConvert.SerializeObject(body);
            RestClient client = new RestClient(paymentURL, HttpVerb.POST, jsonBody);
            string response = client.MakeRequest();
            if (response == null) return null;
            JObject responseObject = JsonConvert.DeserializeObject<JObject>(response);
            string responseSignature = responseObject.GetValue("signature").ToString();
            string responseMessage = responseObject.GetValue("messages").ToString();
            bool isSignatureVerified = RSA.VerifyRSASHA1(responseMessage, responseSignature, publicKey);
            if (isSignatureVerified)
            {
                return JsonConvert.DeserializeObject<JObject>(responseMessage);
            }
            return null;
        }



    }
}