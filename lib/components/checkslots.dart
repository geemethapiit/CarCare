import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:intl/intl.dart';
import '../config/auth_services.dart';
import '../config/global.dart';
import 'booking_form.dart';
import 'com_button.dart';
import 'config.dart';

class CheckSlots extends StatefulWidget {

  final List<Map<String, String>> branches;


  const CheckSlots({
    super.key,
    required this.branches,
  });

  @override
  State<CheckSlots> createState() => _CheckSlotsState();
}

class _CheckSlotsState extends State<CheckSlots> {

  String? _selectedBranchId;
  String? _selectedBranchName;
  DateTime? _selectedDate;
  bool _isLoading = false;


  Future<void> checkSlot() async {
    if (_selectedBranchId == null || _selectedDate == null) {
      errorSnackBar(context, "Please select branch and date");
      return;
    }

    setState(() {
      _isLoading = true;
    });

    try {
      final slots = await AuthServices.fetchAvailableTimeSlots(_selectedBranchId!, _selectedDate!);

      List<Map<String, String>> services = await AuthServices.fetchServices();
      List<String> vehicles = await AuthServices.fetchVehicles();

      // Navigate to the booking form with the available slots
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => BookingForm(
            slots: slots,
            date: _selectedDate!,
            services: services, // You might want to fetch services here as well
            vehicles: vehicles,
            branchId: _selectedBranchId!,
            branchName: _selectedBranchName!, // And also vehicles
          ),
        ),
      );
    } catch (e) {
      print('Error fetching slots: $e');
      errorSnackBar(context, 'Error fetching slots');
    } finally {
      setState(() {
        _isLoading = false;
      });
    }
  }




  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        appBar: PreferredSize(
          preferredSize: Size.fromHeight(100.0),
          child: AppBar(
            centerTitle: true,
            title: Padding(
              padding: EdgeInsets.only(top: 30.0),
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
                  Config.spaceSmall,
                  Config.spaceSmall,
                  Container(
                    padding: EdgeInsets.all(20.0),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Form(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.start,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Config.spaceSmall,
                          Container(
                            padding: EdgeInsets.symmetric(horizontal: 10.0),
                            decoration: BoxDecoration(
                              border: Border.all(color: Colors.grey),
                              borderRadius: BorderRadius.circular(10),
                            ),
                            child: ListTile(
                              title: Text(
                                'Date: ${_selectedDate != null
                                    ? DateFormat('yyyy-MM-dd').format(_selectedDate!)
                                    : 'Select Date'}',
                              ),
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
                          DropdownButtonFormField<String>(
                            decoration: InputDecoration(
                              labelText: 'Select Branch',
                            ),
                            value: _selectedBranchName,
                            onChanged: (String? newValue) {
                              setState(() {
                                _selectedBranchName = newValue;
                                _selectedBranchId = widget.branches.firstWhere(
                                      (branch) => branch['name'] == newValue,
                                  orElse: () => {'id': ''},
                                )['id'];
                              });
                            },
                            items: widget.branches.map((branch) {
                              return DropdownMenuItem<String>(
                                value: branch['name'],
                                child: Text(branch['name']!),
                              );
                            }).toList(),
                          ),
                          Config.spaceSmall,
                            Padding(padding: EdgeInsets.all(10.0),
                              child:
                              ComButton(
                                width: 300,
                                height: 50,
                                title: 'Check Slots',
                                disable: false,
                                color: '#512DA8',
                                onPressed: checkSlot,
                              ),),
                          ],
                      ),
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
