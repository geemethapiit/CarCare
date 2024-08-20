import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'com_button.dart';
import 'config.dart';

class FeedbackForm extends StatefulWidget {
  final List<Map<String, String>> services;
  final List<Map<String, String>> branches;

  const FeedbackForm({
    super.key,
    required this.branches,
    required this.services,
  });

  @override
  State<FeedbackForm> createState() => _FeedbackFormState();
}

class _FeedbackFormState extends State<FeedbackForm> {
  String? _selectedBranchId;
  String? _selectedBranchName;
  String? _selectedServiceTypeName;
  String? _selectedServiceTypeId;
  double _rating = 3.0;

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        appBar: PreferredSize(
          preferredSize: const Size.fromHeight(100.0),
          child: AppBar(
            centerTitle: true,
            title: const Padding(
              padding: EdgeInsets.only(top: 30.0),
              child: Text(
                'Feedback Form',
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
            padding: const EdgeInsets.symmetric(horizontal: 40.0),
            child: SafeArea(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Config.spaceSmall,
                  Config.spaceSmall,
                  Container(
                    padding: const EdgeInsets.all(20.0),
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
                          DropdownButtonFormField<String>(
                            decoration: const InputDecoration(
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
                          DropdownButtonFormField<String>(
                            decoration: const InputDecoration(
                              labelText: 'Select Service Type',
                            ),
                            value: _selectedServiceTypeName,
                            onChanged: (String? newValue) {
                              setState(() {
                                _selectedServiceTypeName = newValue;
                                _selectedServiceTypeId = widget.services.firstWhere(
                                      (service) => service['ServiceTypeName'] == newValue,
                                  orElse: () => {'ServiceTypeID': ''},
                                )['ServiceTypeID'];
                              });
                            },
                            items: widget.services.map((service) {
                              return DropdownMenuItem<String>(
                                value: service['ServiceTypeName'],
                                child: Text(service['ServiceTypeName']!),
                              );
                            }).toList(),
                          ),
                          Config.spaceSmall,
                          TextFormField(
                            maxLines: 4,
                            decoration: InputDecoration(
                              labelText: 'Feedback',
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(10),
                              ),
                            ),
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Please enter some text';
                              }
                              return null;
                            },
                          ),
                          Config.spaceSmall,
                          const Text(
                            'Rating',
                            style: TextStyle(fontSize: 16),
                          ),
                          RatingBar.builder(
                            initialRating: _rating,
                            minRating: 1,
                            direction: Axis.horizontal,
                            allowHalfRating: false,
                            itemCount: 5,
                            itemPadding: const EdgeInsets.symmetric(horizontal: 4.0),
                            itemBuilder: (context, _) => const Icon(
                              Icons.star,
                              color: Colors.amber,
                            ),
                            onRatingUpdate: (rating) {
                              setState(() {
                                _rating = rating;
                              });
                            },
                          ),
                          Config.spaceSmall,
                          ComButton(
                            width: 300,
                            height: 50,
                            title: 'Submit',
                            disable: false,
                            color: '#512DA8',
                            onPressed: () {
                              // Submit logic here
                            },
                          ),
                        ],
                      ),
                    ),
                  ),
                  Config.spaceSmall,
                  Config.spaceSmall,
                  Config.spaceSmall,
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
