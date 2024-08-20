  import 'package:flutter/material.dart';
  import '../config/auth_services.dart';
  import '../config/global.dart';
  import 'com_button.dart';
  import 'config.dart';
  import 'package:http/http.dart' as http;
  import 'dart:convert';

  class VehicleApplication extends StatefulWidget {
    const VehicleApplication({super.key});

    @override
    State<VehicleApplication> createState() => _VehicleApplicationState();
  }

  class _VehicleApplicationState extends State<VehicleApplication> {
    final formKey = GlobalKey<FormState>();
    final vehicleNoController = TextEditingController();
    final vehicleModelController = TextEditingController();
    final vehicleYearController = TextEditingController();

    @override
    void dispose() {
      vehicleNoController.dispose();
      vehicleModelController.dispose();
      vehicleYearController.dispose();
      super.dispose();
    }


    submitForm() async {
      if (formKey.currentState!.validate()) {
        String _vehicleNo = vehicleNoController.text;
        String _vehicleModel = vehicleModelController.text;
        int _vehicleYear = int.parse(vehicleYearController.text);

        try {
          String? authToken = await AuthServices.getToken();  // Get the authentication token
          if (authToken == null) {
            errorSnackBar(context, 'Authentication token not found.');
            return;
          }
          http.Response response = await AuthServices.vehicleregister(
            _vehicleNo,
            _vehicleModel,
            _vehicleYear,
          );
          print('API Response: ${response.body}'); // Debugging
          Map responseMap = jsonDecode(response.body);
          if (response.statusCode == 201) {
            showDialog(
              context: context,
              builder: (BuildContext context) {
                return AlertDialog(
                  title: Text('Success'),
                  content: Text('Vehicle successfully created.'),
                  actions: <Widget>[
                    TextButton(
                      child: Text('OK'),
                      onPressed: () {
                        Navigator.of(context).pop();  // Close the dialog
                        Navigator.pushReplacementNamed(context, '/main');  // Navigate to the main screen
                      },
                    ),
                  ],
                );
              },
            );
          } else {
            print('Response Status Code: ${response.statusCode}'); // Debugging
            print('Response Body: ${response.body}'); // Debugging
            errorSnackBar(context, responseMap['message'] ?? 'An error occurred.');
          }
        } catch (e) {
          print('Error: $e'); // Debugging
          errorSnackBar(context, 'An error occurred. Please try again.');
        }
      }
    }




    @override
    Widget build(BuildContext context) {
      return Form(
        key: formKey,
        child: Padding(
          padding: Config.PaddingBorder,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Container(
                width: 85,
                height: 4,
                color: Colors.black,
              ),
              Config.spaceSmall,
              Config.spaceSmall,
              Text(
                "Add Your Vehicle",
                style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Colors.deepPurple),
              ),
              Config.spaceSmall,
              TextFormField(
                controller: vehicleNoController,
                keyboardType: TextInputType.text,
                cursorColor: Config.primaryColor,
                decoration: const InputDecoration(
                  labelText: 'Vehicle Number',
                  prefixIcon: Icon(Icons.directions_car),
                  prefixIconColor: Config.primaryColor,
                  border: OutlineInputBorder(),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Please enter your vehicle number';
                  }
                  return null;
                },
              ),
              Config.spaceSmall,
              TextFormField(
                controller: vehicleModelController,
                keyboardType: TextInputType.text,
                cursorColor: Config.primaryColor,
                decoration: const InputDecoration(
                  labelText: 'Vehicle Brand & Model',
                  prefixIcon: Icon(Icons.model_training),
                  prefixIconColor: Config.primaryColor,
                  border: OutlineInputBorder(),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Please enter your vehicle brand & model';
                  }
                  return null;
                },
              ),
              Config.spaceSmall,
              TextFormField(
                controller: vehicleYearController,
                keyboardType: TextInputType.text,
                cursorColor: Config.primaryColor,
                decoration: const InputDecoration(
                  labelText: 'Vehicle Year',
                  prefixIcon: Icon(Icons.calendar_today),
                  prefixIconColor: Config.primaryColor,
                  border: OutlineInputBorder(),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Please enter your vehicle year';
                  }
                  return null;
                },
              ),
              Config.spaceSmall,
              Config.spaceSmall,
              ComButton(
                width: 300,
                height: 40,
                title: 'Submit',
                disable: false,
                color: '#512DA8',
                onPressed: submitForm,
              ),
              Config.spaceSmall,
            ],
          ),
        ),
      );
    }
  }
