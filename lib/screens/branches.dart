import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../components/branchcard.dart';
import '../Components/config.dart';
import '../config/global.dart';

class BranchedPage extends StatefulWidget {
  const BranchedPage({super.key});

  @override
  State<BranchedPage> createState() => _BranchedPageState();
}

class _BranchedPageState extends State<BranchedPage> {
  bool isLoading = true;
  List<dynamic> branches = [];

  @override
  void initState() {
    super.initState();
    fetchBranchesDetails();
  }

  Future<void> fetchBranchesDetails() async {
    try {
      final response = await http.get(
        Uri.parse(baseURL + '/branches/details'),
        headers: {
          'Content-Type': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        setState(() {
          branches = json.decode(response.body);
          isLoading = false;
        });
      } else {
        throw Exception('Failed to load branches');
      }
    } catch (e) {
      print('Error fetching branches: $e');
      setState(() {
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        appBar: PreferredSize(
          preferredSize: const Size.fromHeight(100.0),
          child: AppBar(
            centerTitle: true,
            title: const Padding(
              padding: EdgeInsets.only(top: 30.0),
              child: Text(
                'Our Branches',
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
        backgroundColor: Colors.transparent,
        body: isLoading
            ? const Center(child: CircularProgressIndicator())
            : Padding(
          padding: const EdgeInsets.all(20),
          child: ListView.builder(
            itemCount: branches.length,
            itemBuilder: (context, index) {
              final branch = branches[index];
              return Padding(
                padding: const EdgeInsets.all(8.0),
                child: BranchCard(
                  branchId: branch['BranchID'].toString(),  // Ensure key names match the API response
                  branchName: branch['name'].toString(),
                  address: branch['address'].toString(),
                  telephone: branch['telephone'].toString(),
                ),
              );
            },
          ),
        ),
      ),
    );
  }
}
