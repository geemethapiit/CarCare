import 'dart:convert';
import 'package:carcareproject/components/com_button.dart';
import 'package:carcareproject/components/config.dart';
import 'package:carcareproject/screens/sign_up_page.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../components/fade_animation.dart';
import '../config/auth_services.dart';
import '../config/global.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final formkey = GlobalKey<FormState>();
  final emailController = TextEditingController();
  final passController = TextEditingController();
  bool passwordVisible = false;

  @override
  void dispose() {
    emailController.dispose();
    passController.dispose();
    super.dispose();
  }

  loginPressed() async {
    if (formkey.currentState != null && formkey.currentState!.validate()) {
      String _email = emailController.text;
      String _password = passController.text;

      print('Email: $_email');  // Debugging
      print('Password: $_password');  // Debugging

      try {
        http.Response response = await AuthServices.login(_email, _password);
        if (response.body.isNotEmpty) {
          Map<String, dynamic> responseMap = jsonDecode(response.body);

          if (response.statusCode == 200) {
            Navigator.pushReplacementNamed(context, '/main');
          } else if (response.statusCode == 401) {
            errorSnackBar(context, "Invalid login. Please check your email and password.");
          } else {
            errorSnackBar(context, responseMap.values.first ?? "An error occurred. Please try again.");
          }
        } else {
          errorSnackBar(context, "Empty response from server. Please try again.");
        }
      } catch (e) {
        errorSnackBar(context, "An unexpected error occurred. Please try again.");
      }
    } else {
      errorSnackBar(context, "Enter all required fields");
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
                height: 400,
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
                          child: const Center(
                            child: Text(
                              "Login",
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
                child: Column(
                  children: <Widget>[
                    FadeAnimation(
                      Container(
                        padding: EdgeInsets.all(5),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(10),
                          boxShadow: const [
                            BoxShadow(
                              color: Color.fromRGBO(143, 148, 251, .2),
                              blurRadius: 20.0,
                              offset: Offset(0, 10),
                            ),
                          ],
                        ),
                        child: Form(
                          key: formkey, // Add the form key here
                          child: Column(
                            children: <Widget>[
                              Container(
                                padding: const EdgeInsets.all(8.0),
                                child: TextFormField(
                                  controller: emailController,
                                  keyboardType: TextInputType.emailAddress,
                                  cursorColor: Config.primaryColor,
                                  decoration: const InputDecoration(
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
                                        passwordVisible
                                            ? Icons.visibility
                                            : Icons.visibility_off,
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
                      ),
                      1.8,
                    ),
                    Align(
                      alignment: Alignment.centerRight,
                      child: FadeAnimation(
                        TextButton(
                          onPressed: () {
                            // Add your onPressed code here!
                          },
                          child: const Text(
                            "Forgot Password?",
                            style: TextStyle(
                                color: Color.fromRGBO(143, 148, 251, 1)),
                          ),
                        ),
                        2.0,
                      ),
                    ),
                    Config.spaceSmall,
                    ComButton(
                        width: 400,
                        height: 40,
                        title: "Login",
                        disable: false,
                        color: '#512DA8',
                        onPressed: loginPressed),
                    Config.spaceSmall,
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Text("Don't have an account?"),
                        FadeAnimation(
                          TextButton(
                            onPressed: () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(
                                  builder: (context) => SignUpPage(),
                                ),
                              );
                            },
                            child: const Text(
                              "Create Account",
                              style: TextStyle(
                                  color: Color.fromRGBO(143, 148, 251, 1)),
                            ),
                          ),
                          2.0,
                        ),
                      ],
                    )
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
