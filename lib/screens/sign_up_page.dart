import 'dart:convert';
import 'package:carcareproject/screens/login_page.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../components/com_button.dart';
import '../components/config.dart';
import '../components/fade_animation.dart';
import '../config/auth_services.dart';
import '../config/global.dart';

class SignUpPage extends StatefulWidget {
  const SignUpPage({super.key});

  @override
  State<SignUpPage> createState() => _SignUpPageState();
}

class _SignUpPageState extends State<SignUpPage> {
  final formKey = GlobalKey<FormState>();
  final nameController = TextEditingController();
  final emailController = TextEditingController();
  final passController = TextEditingController();
  final addressController = TextEditingController();
  final phoneController = TextEditingController();
  bool passwordVisible = false;

  @override
  void dispose() {
    nameController.dispose();
    emailController.dispose();
    passController.dispose();
    phoneController.dispose();
    addressController.dispose();
    super.dispose();
  }

  createAccountPressed() async {
    if (formKey.currentState!.validate()) {
      String _name = nameController.text;
      String _email = emailController.text;
      String _password = passController.text;
      String _phoneNo = phoneController.text;
      String _address = addressController.text;

      bool emailValid = RegExp(
          r"^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
      ).hasMatch(_email);

      if (emailValid) {
        try {
          http.Response response = await AuthServices.register(_name, _email, _password, _address, _phoneNo);
          print('API Response: ${response.body}'); // Debugging
          Map responseMap = jsonDecode(response.body);
          if (response.statusCode == 200) {
            Navigator.pushReplacementNamed(context, '/main');
          } else {
            print('Response Status Code: ${response.statusCode}'); // Debugging
            print('Response Body: ${response.body}'); // Debugging
            errorSnackBar(context, responseMap['errors']['phoneNo'][0]);
          }
        } catch (e) {
          print('Error: $e'); // Debugging
          errorSnackBar(context, 'An error occurred. Please try again.');
        }
      } else {
        errorSnackBar(context, "Email not valid");
      }
    }
  }


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: SingleChildScrollView(
        child: Container(
          child: Column(
            children: <Widget>[
              Container(
                height: 300,
                decoration: const BoxDecoration(
                  image: DecorationImage(
                    image: AssetImage('assets/images/background.png'),
                    fit: BoxFit.fill,
                  ),
                ),
                child: Stack(
                  children: <Widget>[
                    Positioned(
                      child: FadeAnimation(
                        Container(
                          margin: EdgeInsets.only(top: 50),
                          child: Center(
                            child: Text(
                              "Sign Up",
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: 54,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                        ),
                        1.6,
                      ),
                    ),
                  ],
                ),
              ),
              Padding(
                padding: EdgeInsets.all(30.0),
                child: Form( // Wrap the form elements with Form widget
                  key: formKey,
                  child: Column(
                    children: <Widget>[
                      FadeAnimation(
                        Container(
                          padding: EdgeInsets.all(5),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(10),
                            boxShadow: [
                              BoxShadow(
                                color: Color.fromRGBO(143, 148, 251, .2),
                                blurRadius: 20.0,
                                offset: Offset(0, 10),
                              ),
                            ],
                          ),
                          child: Column(
                            children: <Widget>[
                              Container(
                                padding: EdgeInsets.all(8.0),
                                child: TextFormField(
                                  controller: nameController,
                                  keyboardType: TextInputType.text,
                                  cursorColor: Config.primaryColor,
                                  decoration: InputDecoration(
                                    labelText: 'Name',
                                    prefixIcon: Icon(Icons.account_box),
                                    prefixIconColor: Config.primaryColor,
                                    border: OutlineInputBorder(),
                                  ),
                                  validator: (value) {
                                    if (value == null || value.isEmpty) {
                                      return 'Please enter your Name';
                                    }
                                    return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                child: TextFormField(
                                  controller: addressController,
                                  keyboardType: TextInputType.text,
                                  cursorColor: Config.primaryColor,
                                  decoration: InputDecoration(
                                    labelText: 'Address',
                                    prefixIcon: Icon(Icons.location_on),
                                    prefixIconColor: Config.primaryColor,
                                    border: OutlineInputBorder(),
                                  ),
                                  validator: (value) {
                                    if (value == null || value.isEmpty) {
                                      return 'Please enter your Address';
                                    }
                                    return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                child: TextFormField(
                                  controller: phoneController,
                                  keyboardType: TextInputType.phone,
                                  cursorColor: Config.primaryColor,
                                  decoration: InputDecoration(
                                    labelText: 'Contact Number',
                                    prefixIcon: Icon(Icons.phone_android),
                                    prefixIconColor: Config.primaryColor,
                                    border: OutlineInputBorder(),
                                  ),
                                  validator: (value) {
                                    if (value == null || value.isEmpty) {
                                      return 'Please enter your Contact Number';
                                    }
                                    return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                child: TextFormField(
                                  controller: emailController,
                                  keyboardType: TextInputType.emailAddress,
                                  cursorColor: Config.primaryColor,
                                  decoration: InputDecoration(
                                    labelText: 'Email',
                                    prefixIcon: Icon(Icons.email_outlined),
                                    prefixIconColor: Config.primaryColor,
                                    border: OutlineInputBorder(),
                                  ),
                                  validator: (value) {
                                    if (value == null || value.isEmpty) {
                                      return 'Please enter your email';
                                    }
                                    return null;
                                  },
                                ),
                              ),
                              Container(
                                padding: EdgeInsets.all(8.0),
                                child: TextFormField(
                                  controller: passController,
                                  keyboardType: TextInputType.visiblePassword,
                                  cursorColor: Config.primaryColor,
                                  obscureText: !passwordVisible,
                                  decoration: InputDecoration(
                                    labelText: 'Password',
                                    prefixIcon: const Icon(Icons.lock_outline),
                                    prefixIconColor: Config.primaryColor,
                                    border: OutlineInputBorder(),
                                    suffixIcon: IconButton(
                                      icon: Icon(
                                        passwordVisible ? Icons.visibility : Icons.visibility_off,
                                      ),
                                      onPressed: () {
                                        setState(() {
                                          passwordVisible = !passwordVisible;
                                        });
                                      },
                                    ),
                                  ),
                                  validator: (value) {
                                    if (value == null || value.isEmpty) {
                                      return 'Please enter your password';
                                    }
                                    return null;
                                  },
                                ),
                              ),
                            ],
                          ),
                        ),
                        1.8,
                      ),
                      Config.spaceSmall,
                      ComButton(width: 400, height: 40, title: "Sign Up", disable: false, color: '#512DA8', onPressed: createAccountPressed,),
                      Config.spaceSmall,
                      Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Text("Already have an account?"),
                          FadeAnimation(
                            TextButton(
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                    builder: (context) => LoginPage(),
                                  ),
                                );
                              },
                              child: const Text(
                                "Login",
                                style: TextStyle(color: Color.fromRGBO(143, 148, 251, 1)),
                              ),
                            ),
                            2.0,
                          ),
                        ],
                      )
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
