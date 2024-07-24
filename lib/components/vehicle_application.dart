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
  final vehicleBrandController = TextEditingController();
  final vehicleModelController = TextEditingController();
  final vehicleYearController = TextEditingController();

  @override
  void dispose() {
    vehicleNoController.dispose();
    vehicleBrandController.dispose();
    vehicleModelController.dispose();
    vehicleYearController.dispose();
    super.dispose();
  }

  submitForm() async {
    if (formKey.currentState!.validate()) {
      String _vehicleNo = vehicleNoController.text;
      String _vehicleBrand = vehicleBrandController.text;
      String _vehicleModel = vehicleModelController.text;
      String _vehicleYear = vehicleYearController.text;


      if (_vehicleNo.isEmpty || _vehicleBrand.isEmpty || _vehicleModel.isEmpty || _vehicleYear.isEmpty) {
        try {
          http.Response response = await AuthServices.vehicleregister(_vehicleNo, _vehicleBrand, _vehicleModel, _vehicleYear,);
          print('API Response: ${response.body}'); // Debugging
          Map responseMap = jsonDecode(response.body);
          if (response.statusCode == 200) {
            Navigator.pushReplacementNamed(context, '/main');
          } else {
            print('Response Status Code: ${response.statusCode}'); // Debugging
            print('Response Body: ${response.body}'); // Debugging
          }
        } catch (e) {
          print('Error: $e'); // Debugging
          errorSnackBar(context, 'An error occurred. Please try again.');
        }
      } else {
        errorSnackBar(context, "Not valid");
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
              controller: vehicleBrandController,
              keyboardType: TextInputType.text,
              cursorColor: Config.primaryColor,
              decoration: const InputDecoration(
                labelText: 'Vehicle Brand',
                prefixIcon: Icon(Icons.branding_watermark),
                prefixIconColor: Config.primaryColor,
                border: OutlineInputBorder(),
              ),
              validator: (value) {
                if (value == null || value.isEmpty) {
                  return 'Please enter your vehicle brand';
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
                labelText: 'Vehicle Model',
                prefixIcon: Icon(Icons.model_training),
                prefixIconColor: Config.primaryColor,
                border: OutlineInputBorder(),
              ),
              validator: (value) {
                if (value == null || value.isEmpty) {
                  return 'Please enter your vehicle model';
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
