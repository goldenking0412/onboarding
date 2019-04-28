<?php

use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createFirstSurvey();
        $this->createSecondSurvey();
    }

    protected function createFirstSurvey()
    {
        $survey = \App\Models\Survey::query()->create([
            'survey_name'  => 'Key Info Questionnaire',
        ]);

        $sections = [
            [
                'section_order' => 1,
                'name'  => 'Questions'
            ],
        ];

        $questions = [
            'Questions' => [
                [
                    'question'    => 'What is the name of your product?',
                    'type'        => 'text',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'Please create a "reply-to" email address and send us the email you would like that to be. We will be sending out emails to the list and it is best if it comes from someone at your company, but is separate from their normal email since there will be quite a few responses from potential customers. (For example matt.d@bakblade.com)',
                    'type'        => 'text',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'What are your ESTIMATED cost of goods sold? (how much does it cost to produce one unit)',
                    'type'        => 'text',
                    'question_order'       => 3
                ],
                [
                    'question'    => 'What is your ESTIMATED retail price?',
                    'type'        => 'text',
                    'question_order'       => 4
                ],
                [
                    'question'    => 'What is the lowest price you are willing to discount your product to?',
                    'type'        => 'text',
                    'question_order'       => 5
                ],
            ],
        ];
        foreach ($sections as $sectionData){
            $questionSection = \App\Models\QuestionSection::query()->create(array_merge($sectionData, [
                'survey_id' => $survey->id,
            ]));

            foreach ($questions[$sectionData['name']] as $questionData){
                $questionSection->questions()->create($questionData);
            }
        }
    }
    protected function createSecondSurvey()
    {
        $survey = \App\Models\Survey::query()->create([
            'survey_name'  => 'Brand Messaging Questionnaire',
        ]);

        $sections = [
            [
                'section_order' => 1,
                'name'  => 'Logistics'
            ],
            [
                'section_order' => 2,
                'name'  => 'My Story'
            ],
            [
                'section_order' => 3,
                'name'  => 'High Level'
            ],
            [
                'section_order' => 4,
                'name'  => 'Customer Angle'
            ],
            [
                'section_order' => 5,
                'name'  => 'Salience'
            ],
            [
                'section_order' => 6,
                'name'  => 'Performance'
            ],
            [
                'section_order' => 7,
                'name'  => 'Imagery'
            ],
            [
                'section_order' => 8,
                'name'  => 'Judgements'
            ],
            [
                'section_order' => 9,
                'name'  => 'Resonance'
            ],
            [
                'section_order' => 10,
                'name'  => 'Reference Links'
            ],
            [
                'section_order' => 11,
                'name'  => 'Dream 100'
            ],
            [
                'section_order' => 12,
                'name'  => 'Team'
            ],
            [
                'section_order' => 13,
                'name'  => 'Testimonials'
            ],
        ];

        $questions = [
            'Logistics' => [
                [
                    'question'    => 'Prototype Walkthrough <br><br><small><i>Please provide a link to a short video walkthrough of your prototype explaining how it works, pointing out key features, and explaining what you love most about it / why it’s awesome. This will be used internally for our team to make sure we are handling the product correctly.</small></i>',
                    'type'        => 'text',
                    'question_order'       => 1
                ]
            ],
            'My Story' => [
                [
                    'question'    => 'Here’s who I am and how I got to where I am today...',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'Here’s the story behind why I created my product (what problem did you have, how does your product solve that problem, what inspired you, why did you create this product)...',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'Here’s the most common mistakes people make... (in this industry, about this problem, with their solutions)?',
                    'type'        => 'textarea',
                    'question_order'       => 3
                ],
            ],
            'High Level' => [
                [
                    'question'    => 'What is the product, category/industry, and mission for the campaign? (single product, a line of products, a service, an expedition, etc.)',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'Why this product? Why now?',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'Why you?',
                    'type'        => 'textarea',
                    'question_order'       => 3
                ],
                [
                    'question'    => 'What need/problem/pain points are you solving?',
                    'type'        => 'textarea',
                    'question_order'       => 4
                ],
                [
                    'question'    => 'How do you solve that problem?',
                    'type'        => 'textarea',
                    'question_order'       => 5
                ],
                [
                    'question'    => 'Why do people really want this product?',
                    'type'        => 'textarea',
                    'question_order'       => 6
                ],
                [
                    'question'    => 'What is your financial goal for the campaign? <i>(what does success look like to you?)</i>',
                    'type'        => 'textarea',
                    'question_order'       => 7
                ],
                [
                    'question'    => 'What’s your expected retail cost? <i>(if you are selling multiple products, please list the retail price for each)</i>',
                    'type'        => 'textarea',
                    'question_order'       => 8
                ],
                [
                    'question'    => 'What are your cost of your goods? <i>(if you are selling multiple products, please list the cost of goods for each)</i>',
                    'type'        => 'textarea',
                    'question_order'       => 9
                ],
                [
                    'question'    => 'What is the absolute lowest price price you can offer your product at? <i>(this assists us in creating our reward structure & discount levels)</i>',
                    'type'        => 'textarea',
                    'question_order'       => 10
                ],
                [
                    'question'    => 'What items consist of your main product offering? <i>Example for baKblade: baKblade 2.0, 4 Pack of Blades, Wall Mount</i>',
                    'type'        => 'textarea',
                    'question_order'       => 11
                ],
                [
                    'question'    => 'Where will you be able to ship your product? <i>(List countries you can ship to or countries you cannot)</i>',
                    'type'        => 'textarea',
                    'question_order'       => 12
                ],
                [
                    'question'    => 'Who are your competitors & what are their price points?',
                    'type'        => 'textarea',
                    'question_order'       => 13
                ],
            ],
            'Customer Angle' => [
                [
                    'question'    => 'Problem - Describe an incident or condition that motivates the use of the solution',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'Solution - Show how they access and use the solution to address their need',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'Outcome - Describe the outcome of the situation: the payoff, the problem solved, the happy user, the final dream',
                    'type'        => 'textarea',
                    'question_order'       => 3
                ],
            ],
            'Salience' => [
                [
                    'question'    => 'What is the product?',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'How do you use the product? How does it work - step by step?',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'What industry are you in?',
                    'type'        => 'textarea',
                    'question_order'       => 3
                ],
            ],
            'Performance' => [
                [
                    'question'    => 'Features - List all the features and explain their function and value.',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'Uniqueness - What separates you from your competitors? Why will your customers only work with you?',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'Accessibility / Affordability - How affordable is it compared to the market? How rare or easy is it to obtain?',
                    'type'        => 'textarea',
                    'question_order'       => 3
                ],
            ],
            'Imagery' => [
                [
                    'question'    => 'Creative Assets - Provide links to whatever media/creative assets you have here - including, but not limited to, photos of the product, promotional videos made, demonstration videos, testimonials, font files, graphics, logos, etc. ',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'Provide links to inspirations for the look/feel of your brand and product here',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
            ],
            'Judgements' => [
                [
                    'question'    => 'What positive things are people saying about you?',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'What negative things may people saying about you?',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'What concerns, fears, or uncertainties do your customers have about you, the product, and/or the brand?',
                    'type'        => 'textarea',
                    'question_order'       => 3
                ],
                [
                    'question'    => 'What authority do you have in the space?',
                    'type'        => 'textarea',
                    'question_order'       => 4
                ],

            ],
            'Resonance' => [
                [
                    'question'    => 'What is the core purpose of your company?',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'Where do you see your company in the next 10 years?',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
            ],
            'Reference Links' => [
                [
                    'question'    => 'Links to similar campaigns, inspirations, news, articles, etc.',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
            ],
            'Dream 100' => [
                [
                    'question'    => 'Establish your Dream 100 by listing 100 different people, events, organizations, or brands that you would want to promote you and your brand/product/service. <br><br><small>You don’t have to fill out a full 100, but as many as you can, please try to hit at least 15-20 minimum. Examples: Apple, Oprah, NASA, Starbucks, REI, Tim Ferriss, GQ, Disney, Yeti Coolers, Mashable, TechCrunch, Tesla, Lagavulin, Dr. Oz, Alton Brown, Bill Nye, LA Philharmonic Orchestra, Forbes</small>',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
            ],
            'Team' => [
                [
                    'question'    => 'Who is on the team?',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
                [
                    'question'    => 'What are their roles?',
                    'type'        => 'textarea',
                    'question_order'       => 2
                ],
                [
                    'question'    => 'Previous work experience/background of the team (any previous crowdfunding campaigns or start-up’s)?',
                    'type'        => 'textarea',
                    'question_order'       => 3
                ],
                [
                    'question'    => 'Who is the primary spokesman or spokeswoman?',
                    'type'        => 'textarea',
                    'question_order'       => 4
                ],
            ],
            'Testimonials' => [
                [
                    'question'    => '<small>Solid, impactful testimonials can have a HUGE impact on sales. While we prefer to work with 10+, please include at least 3-4 testimonials of your product.
<br><br>
Don’t have any? Having friends/family test out your product works just fine, so long as they’re being honest in their assessment. Or, offer people small gift cards to test your product in return for an honest review.
<br><br>
You may have to get creative with obtaining some early reviews, but we cannot overstate the importance of supplying at least a few solid testimonials.
</small>',
                    'type'        => 'textarea',
                    'question_order'       => 1
                ],
            ]

            
        ];
        foreach ($sections as $sectionData){
            $questionSection = \App\Models\QuestionSection::query()->create(array_merge($sectionData, [
                'survey_id' => $survey->id,
            ]));

            foreach ($questions[$sectionData['name']] as $questionData){
                $questionSection->questions()->create($questionData);
            }
        }
    }
}
