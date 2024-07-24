import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:intl/intl.dart'; // Import for date and time formatting
import '../config/auth_services.dart';
import '../config/global.dart';
import 'com_button.dart';
import 'config.dart';

class BookingForm extends StatefulWidget {
  final List<String> branches;
  final List<String> services;
  final List<String> vehicles;

  const BookingForm({
    super.key,
    required this.branches,
    required this.services,
    required this.vehicles,
  });

  @override
  State<BookingForm> createState() => _BookingFormState();
}

class _BookingFormState extends State<BookingForm> {
  String? _selectedVehicle;
  String? _selectedBranch;
  String? _selectedServiceType;
  DateTime? _selectedDate;
  TimeOfDay? _selectedTime;

  List<String> _vehicles = [];
  List<String> _branches = [];
  List<String> _serviceTypes = [];

  @override
  void initState() {
    super.initState();
    _branches = widget.branches;
    _serviceTypes = widget.services;
    _vehicles = widget.vehicles;
  }

  Future<void> bookNow() async {
    if (_selectedVehicle == null ||
        _selectedBranch == null ||
        _selectedServiceType == null ||
        _selectedDate == null ||
        _selectedTime == null) {
      errorSnackBar(context, "Please fill all fields");
      return;
    }

    try {
      final token = await AuthServices.getToken();
      final response = await http.post(
        Uri.parse(baseURL + 'appointments'),
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
        body: json.encode({
          'date': _selectedDate!.toIso8601String(),
          'time': DateFormat('H:mm').format(DateTime(0, 0, 0, _selectedTime!.hour, _selectedTime!.minute)),
          'ServiceTypeId': _selectedServiceType, // Should be an ID that exists
          'BranchID': _selectedBranch, // Should be an ID that exists
          'vehicle_number': _selectedVehicle,
        }),

      );

      print('Request Headers: ${response.request?.headers}');
      print('Response Status Code: ${response.statusCode}');
      print('Selected Service Type ID: $_selectedServiceType');
      print('Selected Branch ID: $_selectedBranch');
      print('Response Body: ${response.body}');

      if (response.statusCode == 200) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          backgroundColor: Colors.green,
          content: Text('Booking successful'),
        ));
        Navigator.pop(context);
      } else {
        final Map<String, dynamic> responseMap = json.decode(response.body);
        errorSnackBar(context, responseMap['message'] ?? 'Error booking appointment');
      }
    } catch (e) {
      print('Error submitting booking: $e');
      errorSnackBar(context, 'Error submitting booking');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        appBar: PreferredSize(
          preferredSize: Size.fromHeight(150.0),
          child: AppBar(
            centerTitle: true,
            title: Padding(
              padding: EdgeInsets.only(top: 40.0),
              child: Text(
                'Appointment Application',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 24,
                  color: Colors.white,
                ),
              ),
            ),
            backgroundColor: Colors.deepPurple.shade400,
          ),
        ),
        body: SingleChildScrollView(
          child: Padding(
            padding: EdgeInsets.symmetric(horizontal: 40.0),
            child: SafeArea(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Form(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.start,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Config.spaceSmall,
                        Container(
                          width: double.infinity,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(10),
                          ),
                          child: Column(
                            children: [
                              Config.spaceSmall,
                              DropdownButtonFormField<String>(
                                decoration: InputDecoration(
                                    labelText: 'Select Vehicle'),
                                value: _selectedVehicle,
                                onChanged: (String? newValue) {
                                  setState(() {
                                    _selectedVehicle = newValue;
                                  });
                                },
                                items: _vehicles.map((String vehicle) {
                                  return DropdownMenuItem<String>(
                                    value: vehicle,
                                    child: Text(vehicle),
                                  );
                                }).toList(),
                              ),
                              Config.spaceSmall,
                              DropdownButtonFormField<String>(
                                decoration: InputDecoration(
                                    labelText: 'Select Branch'),
                                value: _selectedBranch,
                                onChanged: (String? newValue) {
                                  setState(() {
                                    _selectedBranch = newValue;
                                  });
                                },
                                items: _branches.map((String branch) {
                                  return DropdownMenuItem<String>(
                                    value: branch,
                                    child: Text(branch),
                                  );
                                }).toList(),
                              ),
                              Config.spaceSmall,
                              DropdownButtonFormField<String>(
                                decoration: InputDecoration(
                                    labelText: 'Select Service Type'),
                                value: _selectedServiceType,
                                onChanged: (String? newValue) {
                                  setState(() {
                                    _selectedServiceType = newValue;
                                  });
                                },
                                items: _serviceTypes.map((String service) {
                                  return DropdownMenuItem<String>(
                                    value: service,
                                    child: Text(service),
                                  );
                                }).toList(),
                              ),
                              Config.spaceSmall,
                              Container(
                                padding: EdgeInsets.symmetric(horizontal: 10.0),
                                decoration: BoxDecoration(
                                  border: Border.all(color: Colors.grey),
                                  borderRadius: BorderRadius.circular(10),
                                ),
                                child: ListTile(
                                  title: Text('Date: ${_selectedDate != null
                                      ? DateFormat('yyyy-MM-dd').format(_selectedDate!)
                                      : 'Select Date'}'),
                                  trailing: Icon(Icons.calendar_today),
                                  onTap: () async {
                                    DateTime? pickedDate = await showDatePicker(
                                      context: context,
                                      initialDate: DateTime.now(),
                                      firstDate: DateTime.now(),
                                      lastDate: DateTime(2100),
                                    );
                                    if (pickedDate != null) {
                                      setState(() {
                                        _selectedDate = pickedDate;
                                      });
                                    }
                                  },
                                ),
                              ),
                              Config.spaceSmall,
                              Container(
                                padding: EdgeInsets.symmetric(horizontal: 10.0),
                                decoration: BoxDecoration(
                                  border: Border.all(color: Colors.grey),
                                  borderRadius: BorderRadius.circular(10),
                                ),
                                child: ListTile(
                                  title: Text('Time: ${_selectedTime != null
                                      ? _selectedTime!.format(context)
                                      : 'Select Time'}'),
                                  trailing: Icon(Icons.access_time),
                                  onTap: () async {
                                    TimeOfDay? pickedTime = await showTimePicker(
                                      context: context,
                                      initialTime: TimeOfDay.now(),
                                    );
                                    if (pickedTime != null) {
                                      setState(() {
                                        _selectedTime = pickedTime;
                                      });
                                    }
                                  },
                                ),
                              ),
                              Config.spaceSmall,
                              Config.spaceSmall,
                              ComButton(
                                width: 300,
                                title: "Submit",
                                disable: false,
                                onPressed: bookNow,
                                color: '#FF5733',
                                height: 50,
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
