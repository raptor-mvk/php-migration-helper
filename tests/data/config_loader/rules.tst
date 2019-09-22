{
  "config1.yml": "version: '1.1'\n\nexcluded:\n  - package1\n  - package2\n  - package3\n\nrules:\n  rule1:\n    regexp: 'regexp11'\n    recommendation: 'str11'",
  "config2.yml": "version: '2.2'\n\nexcluded:\n  - package1\n  - package3\n  - package4\n\nrules:\n  rule2:\n    regexp: 'regexp22'\n    recommendation: 'str22'",
  "config3.yml": "version: '3.3'\n\nexcluded:\n  - package2\n  - package1\n  - package5\n\nrules:\n  rule3:\n    regexp: 'regexp33'\n    recommendation: 'str33'"
}